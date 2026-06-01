<?php

namespace App\Http\Controllers;

use App\Models\ClaseBloque;
use App\Models\ReservaClase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaClaseController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('es');

        $fecha = $request->get('fecha', Carbon::today()->toDateString());
        $fechaCarbon = Carbon::parse($fecha);

        return view('reservas.index', compact('fecha', 'fechaCarbon'));
    }

    public function buscar(Request $request)
    {
        Carbon::setLocale('es');

        $request->validate([
            'celular' => ['required', 'string', 'max:255'],
            'fecha' => ['required', 'date'],
        ]);

        $celular = preg_replace('/\D+/', '', $request->celular);
        $fecha = Carbon::parse($request->fecha)->toDateString();
        $fechaCarbon = Carbon::parse($fecha);

        $usuario = User::where('celular', $celular)
            ->where('eliminado', 0)
            ->first();

        if (!$usuario) {
            return redirect()
                ->route('reservas.index', ['fecha' => $fecha])
                ->with('error', 'No encontramos un usuario activo con ese número.');
        }

        $vigencia = $usuario->fechaVigencia ? Carbon::parse($usuario->fechaVigencia)->startOfDay() : null;
        $puedeReservar = $vigencia && $vigencia->gte(Carbon::parse($fecha)->startOfDay());

        $yaTieneReservaEseDia = ReservaClase::where('idUsuario', $usuario->idUsuario)
            ->where('fechaClase', $fecha)
            ->whereIn('estatus', ['reservada', 'asistio'])
            ->exists();



        $esSabado = Carbon::parse($fecha)->dayOfWeek === Carbon::SATURDAY;

        $bloquesQuery = ClaseBloque::where('activo', 1);

        if ($esSabado) {
            $bloquesQuery->where('tipoDia', 'sabado');
        } else {
            $bloquesQuery->where('tipoDia', 'general');
        }



        $bloques = $bloquesQuery
            ->orderBy('orden')
            ->orderBy('horaInicio')
            ->get()
            ->map(function ($bloque) use ($fecha, $usuario) {
                $reservados = ReservaClase::where('idClaseBloque', $bloque->idClaseBloque)
                    ->where('fechaClase', $fecha)
                    ->where('estatus', 'reservada')
                    ->count();

                $bloque->reservados = $reservados;
                $bloque->disponibles = max(0, $bloque->cupoMaximo - $reservados);

                $bloque->usuario_ya_reservo = ReservaClase::where('idClaseBloque', $bloque->idClaseBloque)
                    ->where('fechaClase', $fecha)
                    ->where('idUsuario', $usuario->idUsuario)
                    ->whereIn('estatus', ['reservada', 'asistio'])
                    ->exists();

                return $bloque;
            });

        return view('reservas.seleccionar', compact(
            'usuario',
            'fecha',
            'fechaCarbon',
            'bloques',
            'puedeReservar',
            'yaTieneReservaEseDia'
        ));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'idUsuario' => ['required', 'integer', 'exists:tbl_usuarios,idUsuario'],
            'idClaseBloque' => ['required', 'integer', 'exists:tbl_clases_bloques,idClaseBloque'],
            'fechaClase' => ['required', 'date'],
        ]);

        $usuario = User::where('idUsuario', $request->idUsuario)->where('eliminado', 0)->first();

        if (!$usuario) {
            return redirect()->route('reservas.index')->with('error', 'Usuario no válido.');
        }

        $fechaClase = Carbon::parse($request->fechaClase)->toDateString();
        $fechaClaseCarbon = Carbon::parse($fechaClase)->startOfDay();

        $vigencia = $usuario->fechaVigencia ? Carbon::parse($usuario->fechaVigencia)->startOfDay() : null;

        if (!$vigencia || $vigencia->lt($fechaClaseCarbon)) {
            return redirect()
                ->route('reservas.index', ['fecha' => $fechaClase])
                ->with('error', 'Tu membresía no está vigente para reservar esta clase.');
        }

        $bloque = ClaseBloque::where('idClaseBloque', $request->idClaseBloque)->where('activo', 1)->first();



        if (!$bloque) {
            return redirect()->route('reservas.index', ['fecha' => $fechaClase])->with('error', 'Horario no disponible.');
        }

        $esSabado = Carbon::parse($fechaClase)->dayOfWeek === Carbon::SATURDAY;

        if ($esSabado && $bloque->tipoDia !== 'sabado') {
            return redirect()
                ->route('reservas.index', ['fecha' => $fechaClase])
                ->with('error', 'Para sábado solo está disponible la clase especial de sabado.');
        }

        if (!$esSabado && $bloque->tipoDia !== 'general') {
            return redirect()
                ->route('reservas.index', ['fecha' => $fechaClase])
                ->with('error', 'Este horario no está disponible para la fecha seleccionada.');
        }



        $yaTieneReservaEseDia = ReservaClase::where('idUsuario', $usuario->idUsuario)
            ->where('fechaClase', $fechaClase)
            ->whereIn('estatus', ['reservada', 'asistio'])
            ->exists();

        if ($yaTieneReservaEseDia) {
            return redirect()
                ->route('reservas.index', ['fecha' => $fechaClase])
                ->with('error', 'Ya tienes una reserva para esta fecha.');
        }

        $yaReservoEseBloque = ReservaClase::where('idUsuario', $usuario->idUsuario)
            ->where('idClaseBloque', $bloque->idClaseBloque)
            ->where('fechaClase', $fechaClase)
            ->whereIn('estatus', ['reservada', 'asistio'])
            ->exists();

        if ($yaReservoEseBloque) {
            return redirect()
                ->route('reservas.index', ['fecha' => $fechaClase])
                ->with('error', 'Ya reservaste este horario.');
        }

        DB::transaction(function () use ($usuario, $bloque, $fechaClase) {
            $reservados = ReservaClase::where('idClaseBloque', $bloque->idClaseBloque)
                ->where('fechaClase', $fechaClase)
                ->where('estatus', 'reservada')
                ->lockForUpdate()
                ->count();

            if ($reservados >= $bloque->cupoMaximo) {
                throw new \RuntimeException('Este horario ya no tiene lugares disponibles.');
            }

            ReservaClase::create([
                'idUsuario' => $usuario->idUsuario,
                'idClaseBloque' => $bloque->idClaseBloque,
                'fechaClase' => $fechaClase,
                'fechaReserva' => now(),
                'estatus' => 'reservada',
            ]);
        });

        return redirect()->route('reservas.success', [
            'fecha' => $fechaClase,
            'idUsuario' => $usuario->idUsuario,
            'idClaseBloque' => $bloque->idClaseBloque,
        ]);
    }

    public function success(Request $request)
    {
        Carbon::setLocale('es');

        $fecha = $request->get('fecha');
        $idUsuario = $request->get('idUsuario');
        $idClaseBloque = $request->get('idClaseBloque');

        $usuario = User::find($idUsuario);
        $bloque = ClaseBloque::find($idClaseBloque);
        $fechaCarbon = $fecha ? Carbon::parse($fecha) : null;

        return view('reservas.success', compact('usuario', 'bloque', 'fechaCarbon'));
    }
}