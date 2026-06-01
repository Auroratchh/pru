<?php

namespace App\Http\Controllers;

use App\Models\ReservaClase;
use App\Models\User;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index()
    {
        return view('asistencia.index');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'celular' => ['required', 'string', 'max:255'],
        ]);

        $celular = preg_replace('/\D+/', '', $request->celular);

        $usuario = User::where('celular', $celular)
            ->where('eliminado', 0)
            ->first();

        if (!$usuario) {
            return redirect()->route('asistencia.index')->with('error', 'No encontramos un usuario con ese número.');
        }

        $hoy = Carbon::today();

        $fechaVigencia = $usuario->fechaVigencia ? Carbon::parse($usuario->fechaVigencia)->startOfDay() : null;
        $fechaUltimoPago = $usuario->fechaUltimoPago ? Carbon::parse($usuario->fechaUltimoPago) : null;

        $puedeRegistrar = false;
        $estatusPago = 'Sin vigencia registrada';

        if ($fechaVigencia) {
            if ($fechaVigencia->lt($hoy)) {
                    $estatusPago = 'Vencido';
                    $puedeRegistrar = false;
            } elseif ($fechaVigencia->equalTo($hoy)) {
                    $estatusPago = 'Vence hoy';
                    $puedeRegistrar = true;
            } else {
                $estatusPago = 'Vigente';
                $puedeRegistrar = true;
            }
        }

        $yaRegistroHoy = Asistencia::where('idUsuario', $usuario->idUsuario)->where('fechaAsistencia', $hoy->toDateString())->exists();

        if ($yaRegistroHoy) {
            $puedeRegistrar = false;
        }


        return view('asistencia.confirmar', compact(
            'usuario',
            'fechaUltimoPago',
            'fechaVigencia',
            'estatusPago',
            'puedeRegistrar',
            'yaRegistroHoy'
        ));

    }

    public function guardar(Request $request)
    {
        $request->validate([
            'idUsuario' => ['required', 'integer', 'exists:tbl_usuarios,idUsuario'],
        ]);

        $usuario = User::where('idUsuario', $request->idUsuario)->where('eliminado', 0)->first();
        if (!$usuario) {
            return redirect()->route('asistencia.index')->with('error', 'Usuario no válido para registrar asistencia.');
        }

        $hoy = Carbon::today();
        $ahora = Carbon::now();

        $fechaVigencia = $usuario->fechaVigencia ? Carbon::parse($usuario->fechaVigencia)->startOfDay() : null;

        if (!$fechaVigencia) {
            return redirect()->route('asistencia.index')->with('error', 'No cuentas con una vigencia registrada. Consulta en recepción.');
        }

        if ($fechaVigencia->lt($hoy)) {
            return redirect()->route('asistencia.index')->with('error', 'Tu membresía está vencida. Regulariza tu pago para registrar asistencia.');
        }

        $existe = Asistencia::where('idUsuario', $usuario->idUsuario)->where('fechaAsistencia', $hoy->toDateString())->exists();

        if ($existe) {
            return redirect()->route('asistencia.index')->with('error', 'La asistencia de hoy ya fue registrada.');
        }


        $reserva = ReservaClase::where('idUsuario', $usuario->idUsuario)
            ->where('fechaClase', $hoy->toDateString())->where('estatus', 'reservada')->orderBy('idReservaClase', 'asc')->first();


        Asistencia::create([
            'idUsuario'         => $request->idUsuario,
            'idReservaClase'    => $reserva?->idReservaClase,
            'fechaAsistencia'   => $hoy->toDateString(),
            'horaAsistencia'    => $ahora->format('H:i:s'),
        ]);

        if ($reserva) {
            $reserva->update(['estatus' => 'asistio']);
        }

        return redirect()->route('asistencia.success');
    }

    public function success()
    {
        return view('asistencia.success');
    }
}