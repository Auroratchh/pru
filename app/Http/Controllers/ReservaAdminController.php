<?php

namespace App\Http\Controllers;

use App\Models\ClaseBloque;
use App\Models\ReservaClase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }


    public function index(Request $request)
    {
        Carbon::setLocale('es');

        $fecha = $request->get('fecha', Carbon::today()->toDateString());
        $fechaCarbon = Carbon::parse($fecha);

        $esSabado = Carbon::parse($fecha)->dayOfWeek === Carbon::SATURDAY;

        $bloquesQuery = ClaseBloque::query()
            ->where('activo', 1);

        if ($esSabado) {
            $bloquesQuery->where('tipoDia', 'sabado');
        } else {
            $bloquesQuery->where('tipoDia', 'general');
        }


        $bloques = $bloquesQuery
            ->orderBy('orden')
            ->orderBy('horaInicio')
            ->get()
            ->map(function ($bloque) use ($fecha) {
                $reservas = ReservaClase::with('usuario')
                    ->where('idClaseBloque', $bloque->idClaseBloque)
                    ->where('fechaClase', $fecha)
                    ->whereIn('estatus', ['reservada', 'asistio'])
                    ->orderBy('fechaReserva', 'asc')
                    ->get();

                $bloque->reservas_del_dia = $reservas;
                $bloque->total_reservas = $reservas->count();
                $bloque->disponibles = max(0, $bloque->cupoMaximo - $bloque->total_reservas);
                $bloque->ocupacion_porcentaje = $bloque->cupoMaximo > 0
                    ? round(($bloque->total_reservas / $bloque->cupoMaximo) * 100)
                    : 0;

                return $bloque;
            });

        $totalBloques = $bloques->count();
        $totalReservas = $bloques->sum('total_reservas');
        $totalDisponibles = $bloques->sum('disponibles');
        $capacidadTotal = $bloques->sum('cupoMaximo');

        return view('admin.reservas.index', compact(
            'fecha',
            'fechaCarbon',
            'bloques',
            'totalBloques',
            'totalReservas',
            'totalDisponibles',
            'capacidadTotal'
        ));
    }

    public function cancelar($idReservaClase)
    {
        $reserva = ReservaClase::with(['usuario', 'bloque'])
            ->where('idReservaClase', $idReservaClase)
            ->where('estatus', 'reservada')
            ->firstOrFail();

        $reserva->update([
            'estatus' => 'cancelada',
        ]);

        return back()->with('success', 'La reserva fue cancelada correctamente.');
    }
}