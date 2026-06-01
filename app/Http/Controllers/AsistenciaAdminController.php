<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\ReservaClase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsistenciaAdminController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('es');

        $fecha = $request->filled('fecha') ? Carbon::parse($request->fecha)->toDateString() : Carbon::today()->toDateString();

        $fechaCarbon = Carbon::parse($fecha);

        /*
        |--------------------------------------------------------------------------
        | ASISTIERON
        |--------------------------------------------------------------------------
        */
        $asistieron = Asistencia::with(['usuario', 'reserva.bloque'])->where('fechaAsistencia', $fecha)
            ->whereHas('usuario', function ($q) {$q->where('eliminado', 0);})
            ->orderBy('horaAsistencia', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | IDS DE USUARIOS QUE ASISTIERON
        |--------------------------------------------------------------------------
        */
        $idsAsistieron = $asistieron->pluck('idUsuario')->unique()->toArray();

        /*
        |--------------------------------------------------------------------------
        | NO ASISTIERON PERO SÍ RESERVARON
        |--------------------------------------------------------------------------
        */
        $noAsistieronConReserva = ReservaClase::with(['usuario', 'bloque'])->where('fechaClase', $fecha)
            ->whereIn('estatus', ['reservada', 'no_asistio'])->whereHas('usuario', function ($q) {$q->where('eliminado', 0);})
            ->when(!empty($idsAsistieron), function ($query) use ($idsAsistieron) {
                $query->whereNotIn('idUsuario', $idsAsistieron);
            })
            ->orderBy('idClaseBloque', 'asc')
            ->orderBy('fechaReserva', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | IDS DE USUARIOS QUE RESERVARON
        |--------------------------------------------------------------------------
        */
        $idsReservaron = $noAsistieronConReserva->pluck('idUsuario')->unique()->toArray();

        /*
        |--------------------------------------------------------------------------
        | NO ASISTIERON Y NO RESERVARON
        |--------------------------------------------------------------------------
        */

        $noAsistieronSinReserva = User::query()->where('eliminado', 0)
            ->when(!empty($idsAsistieron), function ($query) use ($idsAsistieron) {
                $query->whereNotIn('idUsuario', $idsAsistieron);
            })
            ->when(!empty($idsReservaron), function ($query) use ($idsReservaron) {
                $query->whereNotIn('idUsuario', $idsReservaron);
            })
            ->orderBy('nombre')
            ->orderBy('apellidoPaterno')
            ->orderBy('apellidoMaterno')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RESÚMENES
        |--------------------------------------------------------------------------
        */

        $totalMiembros = User::where('eliminado', 0)->count();

        $totalAsistieron                = $asistieron->count();
        $totalNoAsistieronConReserva    = $noAsistieronConReserva->count();
        $totalNoAsistieronSinReserva    = $noAsistieronSinReserva->count();
        $totalFaltaron                  = $totalNoAsistieronConReserva + $totalNoAsistieronSinReserva;

        $vigentes = User::where('eliminado', 0)->whereNotNull('fechaVigencia')->get()
            ->filter(function ($usuario) use ($fechaCarbon) {
                return Carbon::parse($usuario->fechaVigencia)->startOfDay()->gte($fechaCarbon->copy()->startOfDay());
            })->count();

        $vencidos = User::where('eliminado', 0)->get()
            ->filter(function ($usuario) use ($fechaCarbon) {
                if (!$usuario->fechaVigencia) {
                    return true;
                }
                return Carbon::parse($usuario->fechaVigencia)->startOfDay()->lt($fechaCarbon->copy()->startOfDay());
            })
            ->count();

        /*
       |--------------------------------------------------------------------------
       | SI EL DÍA YA ESTÁ CERRADO
       |--------------------------------------------------------------------------
       */
        $reservasPendientes = ReservaClase::where('fechaClase', $fecha)->where('estatus', 'reservada')->count();

        $diaCerrado = $reservasPendientes === 0;

        return view('admin.asistencias.index', compact(
            'fecha',
            'fechaCarbon',
            'asistieron',
            'noAsistieronConReserva',
            'noAsistieronSinReserva',
            'totalMiembros',
            'totalAsistieron',
            'totalNoAsistieronConReserva',
            'totalNoAsistieronSinReserva',
            'totalFaltaron',
            'vigentes',
            'vencidos',
            'reservasPendientes',
            'diaCerrado'
        ));

    }

    public function cerrarDia(Request $request)
    {
        $request->validate([
            'fecha' => ['required', 'date'],
        ]);

        $fecha = Carbon::parse($request->fecha)->toDateString();

        $actualizadas = ReservaClase::where('fechaClase', $fecha)
            ->where('estatus', 'reservada')->update(['estatus' => 'no_asistio', 'updated_at' => now(),]);

        return redirect()
            ->route('admin.asistencias.index', ['fecha' => $fecha])
            ->with('success', "Cierre de día realizado correctamente. Reservas marcadas como no asistió: {$actualizadas}.");
    }
}