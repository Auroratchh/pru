<?php
 
namespace App\Http\Controllers;
 
use App\Models\CategoriaCarga;
use App\Models\CategoriaMov;
use App\Models\CategoriaZona;
use App\Models\ConfProg;
use App\Models\Ejercicio;
use App\Models\Etapa;
use App\Models\Programacion;
use App\Models\ProgEjDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ProgramacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }
 
    public function index(Request $request)
    {
        $txtBuscar = trim((string) $request->get('txtBuscar'));
        $diaPlan   = trim((string) $request->get('diaPlan'));
        $fechaIni  = $request->get('fechaIni');
        $fechaFin  = $request->get('fechaFin');
 
        if (!empty($fechaIni)) {
            $fechaIni = Carbon::createFromFormat('d/m/Y', $fechaIni);
        } else {
            $fechaIni = Carbon::now()->startOfMonth();
        }
 
        if (!empty($fechaFin)) {
            $fechaFin = Carbon::createFromFormat('d/m/Y', $fechaFin);
        } else {
            $fechaFin = Carbon::now()->endOfMonth();
        }
 
        $query = Programacion::query()
            ->with(['usuario', 'configuraciones.etapa'])
            ->whereBetween('fecha', [$fechaIni->toDateString(), $fechaFin->toDateString()]);
 
        if ($diaPlan !== '') {
            $query->where('diaPlan', $diaPlan);
        }
 
        if ($txtBuscar !== '') {
            $query->whereHas('usuario', function ($q) use ($txtBuscar) {
                $q->where('nombre', 'like', "%{$txtBuscar}%")
                    ->orWhere('apellidoPaterno', 'like', "%{$txtBuscar}%");
            });
        }
 
        $programaciones = $query->orderByDesc('fecha')->orderBy('diaPlan')->paginate(20)->appends([
            'txtBuscar' => $txtBuscar,
            'diaPlan'   => $diaPlan,
            'fechaIni'  => $fechaIni->format('d/m/Y'),
            'fechaFin'  => $fechaFin->format('d/m/Y'),
        ]);
 
        $diasPlan = [
            'LUNES'     => 'Lunes',
            'MARTES'    => 'Martes',
            'MIERCOLES' => 'Miércoles',
            'JUEVES'    => 'Jueves',
            'VIERNES'   => 'Viernes',
            'SABADO'    => 'Sábado',
        ];
 
        return view('admin.programaciones.index', compact(
            'programaciones',
            'txtBuscar',
            'diaPlan',
            'fechaIni',
            'fechaFin',
            'diasPlan'
        ));
    }
 
    public function create()
    {
        $etapas = Etapa::where('activo', 1)->pluck('nombre', 'idEtapas');
 
        $diasPlan = [
            'LUNES'     => 'Lunes',
            'MARTES'    => 'Martes',
            'MIERCOLES' => 'Miércoles',
            'JUEVES'    => 'Jueves',
            'VIERNES'   => 'Viernes',
            'SABADO'    => 'Sábado',
        ];
 
        $tiposEntrenamiento = [
            'AMRAP'            => 'AMRAP',
            'EMOM'             => 'EMOM',
            'TABATA'           => 'TABATA',
            'FOR TIME'         => 'FOR TIME',
            'CIRCUIT TRAINING' => 'CIRCUIT TRAINING',
        ];
 
        $ejerciciosPorEtapa = Etapa::where('activo', 1)
            ->with(['ejercicios' => function ($q) {
                $q->where('activo', 1)->orderBy('ejercicio');
            }])
            ->get();
 
        return view('admin.programaciones.create', compact(
            'etapas',
            'diasPlan',
            'tiposEntrenamiento',
            'ejerciciosPorEtapa'
        ));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'fecha'   => ['required', 'date_format:d/m/Y'],
            'diaPlan' => ['required', 'in:LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO'],
        ]);
 
        try {
            DB::beginTransaction();
 
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();
 
            $programacion            = new Programacion();
            $programacion->idUsuario = Auth::user()->idUsuario;
            $programacion->fecha     = $fecha;
            $programacion->diaPlan   = $request->diaPlan;
            $programacion->save();
 
            if ($request->has('bloques') && is_array($request->bloques)) {
                foreach ($request->bloques as $bloque) {
                    if (empty($bloque['idEtapas'])) {
                        continue;
                    }
 
                    $conf                      = new ConfProg();
                    $conf->idProgramacion      = $programacion->idProgramacion;
                    $conf->idEtapas            = $bloque['idEtapas'];
                    $conf->tiposEntrenamiento  = $bloque['tiposEntrenamiento'] ?? null;
                    $conf->descripcion         = $bloque['descripcion'] ?? null;
                    $conf->rounds              = $bloque['rounds'] ?? null;
                    $conf->tiempoTotal         = !empty($bloque['tiempoTotal']) ? $bloque['tiempoTotal'] : null;
                    $conf->tiempoTrabajo       = !empty($bloque['tiempoTrabajo']) ? $bloque['tiempoTrabajo'] : null;
                    $conf->tiempoDescanso      = !empty($bloque['tiempoDescanso']) ? $bloque['tiempoDescanso'] : null;
                    $conf->tiempoEj            = !empty($bloque['tiempoEj']) ? $bloque['tiempoEj'] : null;
                    $conf->repInicio           = $bloque['repInicio'] ?? null;
                    $conf->repEj               = $bloque['repEj'] ?? null;
                    $conf->save();
 
                    // Ejercicios del bloque
                    if (!empty($bloque['ejercicios']) && is_array($bloque['ejercicios'])) {
                        foreach ($bloque['ejercicios'] as $orden => $ej) {
                            if (empty($ej['idEjercicio'])) {
                                continue;
                            }
 
                            $detalle              = new ProgEjDetalle();
                            $detalle->idConfProg  = $conf->idConfProg;
                            $detalle->idEjercicio = $ej['idEjercicio'];
                            $detalle->orden       = $orden + 1;
                            $detalle->series      = $ej['series'] ?? null;
                            $detalle->reps        = $ej['reps'] ?? null;
                            $detalle->pesoInicial = $ej['pesoInicial'] ?? null;
                            $detalle->pesoFinal   = $ej['pesoFinal'] ?? null;
                            $detalle->notas       = $ej['notas'] ?? null;
                            $detalle->save();
                        }
                    }
                }
            }
 
            DB::commit();
 
            return redirect('admin/programaciones/' . $programacion->idProgramacion)
                ->with('status_success', 'Programación creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('status_fail', 'Whoops! ' . $e->getMessage());
        }
    }
 
    public function show($idProgramacion)
    {
        $programacion = Programacion::with([
            'usuario',
            'configuraciones.etapa',
            'configuraciones.ejerciciosDetalle.ejercicio.etapa',
            'configuraciones.ejerciciosDetalle.ejercicio.categoriaZona',
            'configuraciones.ejerciciosDetalle.ejercicio.categoriaCarga',
        ])->findOrFail($idProgramacion);
 
        return view('admin.programaciones.show', compact('programacion'));
    }
 
    public function edit($idProgramacion)
    {
        $programacion = Programacion::with([
            'configuraciones.ejerciciosDetalle',
        ])->findOrFail($idProgramacion);
 
        $etapas = Etapa::where('activo', 1)->pluck('nombre', 'idEtapas');
 
        $diasPlan = [
            'LUNES'     => 'Lunes',
            'MARTES'    => 'Martes',
            'MIERCOLES' => 'Miércoles',
            'JUEVES'    => 'Jueves',
            'VIERNES'   => 'Viernes',
            'SABADO'    => 'Sábado',
        ];
 
        $tiposEntrenamiento = [
            'AMRAP'            => 'AMRAP',
            'EMOM'             => 'EMOM',
            'TABATA'           => 'TABATA',
            'FOR TIME'         => 'FOR TIME',
            'CIRCUIT TRAINING' => 'CIRCUIT TRAINING',
        ];
 
        $ejerciciosPorEtapa = Etapa::where('activo', 1)
            ->with(['ejercicios' => function ($q) {
                $q->where('activo', 1)->orderBy('ejercicio');
            }])
            ->get();
 
        return view('admin.programaciones.edit', compact(
            'programacion',
            'etapas',
            'diasPlan',
            'tiposEntrenamiento',
            'ejerciciosPorEtapa'
        ));
    }
 
    public function update(Request $request, $idProgramacion)
    {
        $request->validate([
            'fecha'   => ['required', 'date_format:d/m/Y'],
            'diaPlan' => ['required', 'in:LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO'],
        ]);
 
        try {
            DB::beginTransaction();
 
            $programacion          = Programacion::findOrFail($idProgramacion);
            $programacion->fecha   = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();
            $programacion->diaPlan = $request->diaPlan;
            $programacion->save();
 
            foreach ($programacion->configuraciones as $conf) {
                $conf->ejerciciosDetalle()->delete();
            }
            $programacion->configuraciones()->delete();
 
            if ($request->has('bloques') && is_array($request->bloques)) {
                foreach ($request->bloques as $bloque) {
                    if (empty($bloque['idEtapas'])) {
                        continue;
                    }
 
                    $conf                     = new ConfProg();
                    $conf->idProgramacion     = $programacion->idProgramacion;
                    $conf->idEtapas           = $bloque['idEtapas'];
                    $conf->tiposEntrenamiento = $bloque['tiposEntrenamiento'] ?? null;
                    $conf->descripcion        = $bloque['descripcion'] ?? null;
                    $conf->rounds             = $bloque['rounds'] ?? null;
                    $conf->tiempoTotal        = !empty($bloque['tiempoTotal']) ? $bloque['tiempoTotal'] : null;
                    $conf->tiempoTrabajo      = !empty($bloque['tiempoTrabajo']) ? $bloque['tiempoTrabajo'] : null;
                    $conf->tiempoDescanso     = !empty($bloque['tiempoDescanso']) ? $bloque['tiempoDescanso'] : null;
                    $conf->tiempoEj           = !empty($bloque['tiempoEj']) ? $bloque['tiempoEj'] : null;
                    $conf->repInicio          = $bloque['repInicio'] ?? null;
                    $conf->repEj              = $bloque['repEj'] ?? null;
                    $conf->save();
 
                    if (!empty($bloque['ejercicios']) && is_array($bloque['ejercicios'])) {
                        foreach ($bloque['ejercicios'] as $orden => $ej) {
                            if (empty($ej['idEjercicio'])) {
                                continue;
                            }
 
                            $detalle              = new ProgEjDetalle();
                            $detalle->idConfProg  = $conf->idConfProg;
                            $detalle->idEjercicio = $ej['idEjercicio'];
                            $detalle->orden       = $orden + 1;
                            $detalle->series      = $ej['series'] ?? null;
                            $detalle->reps        = $ej['reps'] ?? null;
                            $detalle->pesoInicial = $ej['pesoInicial'] ?? null;
                            $detalle->pesoFinal   = $ej['pesoFinal'] ?? null;
                            $detalle->notas       = $ej['notas'] ?? null;
                            $detalle->save();
                        }
                    }
                }
            }
 
            DB::commit();
 
            return redirect('admin/programaciones/' . $programacion->idProgramacion)
                ->with('status_success', 'Programación actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('status_fail' . $e->getMessage());
        }
    }
 
    public function destroy($idProgramacion)
    {
        try {
            DB::beginTransaction();
 
            $programacion = Programacion::with('configuraciones.ejerciciosDetalle')->findOrFail($idProgramacion);
 
            foreach ($programacion->configuraciones as $conf) {
                $conf->ejerciciosDetalle()->delete();
            }
            $programacion->configuraciones()->delete();
            $programacion->delete();
 
            DB::commit();
 
            return redirect('admin/programaciones')->with('status_success', 'Programación eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('status_fail' . $e->getMessage());
        }
    }
}
