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
        $diaPlan = trim((string) $request->get('diaPlan'));
        $fechaIni = $request->get('fechaIni');
        $fechaFin = $request->get('fechaFin');
 
        if (!empty($fechaIni)) {
            $fechaIni = Carbon::createFromFormat('d/m/Y', $fechaIni)->startOfDay();
        } else {
            $fechaIni = Carbon::now()->startOfMonth()->startOfDay();
        }
 
        if (!empty($fechaFin)) {
            $fechaFin = Carbon::createFromFormat('d/m/Y', $fechaFin)->endOfDay();
        } else {
            $fechaFin = Carbon::now()->endOfMonth()->endOfDay();
        }
 
        $query = Programacion::query()
            ->with(['usuario', 'configuraciones.detalles.ejercicio'])
            ->whereBetween('fecha', [$fechaIni, $fechaFin]);
 
        if ($diaPlan !== '') {
            $query->where('diaPlan', $diaPlan);
        }
 
        if ($txtBuscar !== '') {
            $query->whereHas('configuraciones.detalles.ejercicio', function ($q) use ($txtBuscar) {
                $q->where('ejercicio', 'like', '%' . $txtBuscar . '%');
            });
        }
 
        $programaciones = $query->orderBy('fecha', 'DESC')->paginate(50);
 
        return view('admin.programaciones.index', compact('programaciones'));
    }
 
    public function create()
    {
        $etapas = Etapa::where('activo', 1)->orderBy('nombre', 'ASC')->get();
        $ejercicios = Ejercicio::where('activo', 1)->orderBy('ejercicio', 'ASC')->get();
        return view('admin.programaciones.create', compact('etapas', 'ejercicios'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => ['required', 'date_format:d/m/Y'],
            'diaPlan' => ['required', 'in:LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO'],
            'configuraciones' => ['required', 'array'],
        ]);
 
        try {
            DB::beginTransaction();
 
            $programacion = new Programacion();
            $programacion->idUsuario = Auth::id();
            $programacion->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
            $programacion->diaPlan = $request->diaPlan;
            $programacion->save();
 
            foreach ($request->configuraciones as $config) {
                $conf = new ConfProg();
                $conf->idProgramacion = $programacion->idProgramacion;
                $conf->idEtapas = $config['idEtapas'];
                $conf->tiposEntrenamientos = $config['tiposEntrenamientos'] ?? null;
                $conf->descripcion = $config['descripcion'] ?? null;
                $conf->rounds = $config['rounds'] ?? null;
                $conf->tiempoTotal = $config['tiempoTotal'] ?? null;
                $conf->tiempoTrabajo = $config['tiempoTrabajo'] ?? null;
                $conf->tiempoDescanso = $config['tiempoDescanso'] ?? null;
                $conf->tiempoEj = $config['tiempoEj'] ?? null;
                $conf->repInicio = $config['repInicio'] ?? null;
                $conf->repEj = $config['repEj'] ?? null;
                $conf->save();
 
                if (isset($config['ejercicios']) && islands_array($config['ejercicios'])) {
                    foreach ($config['ejercicios'] as $ej) {
                        if (!empty($ej['idEjercicio'])) {
                            $detalle = new ProgEjDetalle();
                            $detalle->idConfProg = $conf->idConfProg;
                            $detalle->idEjercicio = $ej['idEjercicio'];
                            $detalle->orden = $ej['orden'] ?? 1;
                            $detalle->series = $ej['series'] ?? null;
                            $detalle->reps = $ej['reps'] ?? null;
                            $detalle->pesoInicial = $ej['pesoInicial'] ?? null;
                            $detalle->pesoFinal = $ej['pesoFinal'] ?? null;
                            $detalle->nota  = $ej['nota'] ?? null;
                            $detalle->save();
                        }
                    }
                }
            }
 
            DB::commit();
 
            return redirect('admin/programaciones')
                ->with('status_success', 'Programación guardada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('status_fail', $e->getMessage());
        }
    }
 
    public function show($idProgramacion)
    {
        $programacion = Programacion::with(['usuario', 'configuraciones.detalles.ejercicio.etapas'])->findOrFail($idProgramacion);
        return view('admin.programaciones.show', compact('programacion'));
    }
 
    public function edit($idProgramacion)
    {
        $programacion = Programacion::with(['configuraciones.detalles'])->findOrFail($idProgramacion);
        $etapas = Etapa::where('activo', 1)->orderBy('nombre', 'ASC')->get();
        $ejercicios = Ejercicio::where('activo', 1)->orderBy('ejercicio', 'ASC')->get();
 
        return view('admin.programaciones.edit', compact('programacion', 'etapas', 'ejercicios'));
    }
 
    public function update(Request $request, $idProgramacion)
    {
        $request->validate([
            'fecha' => ['required', 'date_format:d/m/Y'],
            'diaPlan' => ['required', 'in:LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO'],
            'configuraciones' => ['required', 'array'],
        ]);
 
        try {
            DB::beginTransaction();
 
            $programacion = Programacion::findOrFail($idProgramacion);
            $programacion->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
            $programacion->diaPlan = $request->diaPlan;
            $programacion->save();
 
            foreach ($programacion->configuraciones as $conf) {
                $conf->detalles()->delete();
            }
            $programacion->configuraciones()->delete();
 
            foreach ($request->configuraciones as $config) {
                $conf = new ConfProg();
                $conf->idProgramacion = $programacion->idProgramacion;
                $conf->idEtapas = $config['idEtapas'];
                $conf->tiposEntrenamientos = $config['tiposEntrenamientos'] ?? null;
                $conf->descripcion = $config['descripcion'] ?? null;
                $conf->rounds = $config['rounds'] ?? null;
                $conf->tiempoTotal = $config['tiempoTotal'] ?? null;
                $conf->tiempoTrabajo = $config['tiempoTrabajo'] ?? null;
                $conf->tiempoDescanso = $config['tiempoDescanso'] ?? null;
                $conf->tiempoEj = $config['tiempoEj'] ?? null;
                $conf->repInicio = $config['repInicio'] ?? null;
                $conf->repEj = $config['repEj'] ?? null;
                $conf->save();
 
                if (isset($config['ejercicios']) && is_array($config['ejercicios'])) {
                    foreach ($config['ejercicios'] as $ej) {
                        if (!empty($ej['idEjercicio'])) {
                            $detalle = new ProgEjDetalle();
                            $detalle->idConfProg = $conf->idConfProg;
                            $detalle->idEjercicio = $ej['idEjercicio'];
                            $detalle->orden = $ej['orden'] ?? 1;
                            $detalle->series  = $ej['series'] ?? null;
                            $detalle->reps = $ej['reps'] ?? null;
                            $detalle->pesoInicial = $ej['pesoInicial'] ?? null;
                            $detalle->pesoFinal = $ej['pesoFinal'] ?? null;
                            $detalle->nota  = $ej['nota'] ?? null;
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
            return back()->withInput()->with('status_fail', $e->getMessage());
        }
    }
 
    public function destroy($idProgramacion)
    {
        try {
            DB::beginTransaction();
 
            $programacion = Programacion::with('configuraciones.detalles')->findOrFail($idProgramacion);
 
            foreach ($programacion->configuraciones as $conf) {
                $conf->detalles()->delete();
            }
            $programacion->configuraciones()->delete();
            $programacion->delete();
 
            DB::commit();
 
            return redirect('admin/programaciones')->with('status_success', 'Programación eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('status_fail', $e->getMessage());
        }
    }
}