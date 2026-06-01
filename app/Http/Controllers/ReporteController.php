<?php

namespace App\Http\Controllers;


use App\Exports\ReporteConcentradoPagosPorMesExport;
use App\Exports\ReporteCorteCajaExport;

use App\Exports\ReportePagosPendientesExport;
use App\Models\Gasto;
use App\Models\Pago;

use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');

    }

    public function corte_caja( Request $request){

        $fechaIni       = $request->get('fechaIni');
        $fechaFin       = $request->get('fechaFin');

        if(!empty($fechaIni)){
            $fechaIni   =  Carbon::CreateFromFormat('d/m/Y H:i:s', $request->input('fechaIni').' 00:00:00');
        }
        else{
            $fechaIni   = Carbon::now()->startOfMonth();
        }
        if(!empty($fechaFin)){
            $fechaFin =  Carbon::CreateFromFormat('d/m/Y H:i:s', $request->input('fechaFin').' 23:59:59');
        }
        else{
            $fechaFin   = Carbon::now()->endOfMonth();
        }

        $pagos          = Pago::getPagosForCorteCaja($fechaIni,$fechaFin);
        $totalPagos     = Pago::getMontoTotalPagosForCorteCaja($fechaIni,$fechaFin);

        $pagoTransferencias = Pago::getMontoTotalPagosTransferenciaForCorteCaja($fechaIni,$fechaFin);
        $pagoEfectivo       = Pago::getMontoTotalPagosEfectivoForCorteCaja($fechaIni,$fechaFin);
        $pagoDepositos      = Pago::getMontoTotalPagosDepositoForCorteCaja($fechaIni,$fechaFin);


        $gastos         = Gasto::getGastosForCorteCaja($fechaIni,$fechaFin);
        $totalGastos    = Gasto::getMontoTotalGastosForCorteCaja($fechaIni,$fechaFin);


        return view('admin.reportes.corte_caja',compact(
            'pagos',
            'pagoTransferencias',
            'pagoEfectivo',
            'pagoDepositos',

            'totalPagos',
            'gastos',
            'totalGastos',
            'fechaIni',
            'fechaFin'
        ));
    }

    public function corte_caja_export( Request $request){

        $fecha              = Carbon::now();

        $fechaIni       = $request->get('fechaIni');
        $fechaFin       = $request->get('fechaFin');

        if(!empty($fechaIni)){
            $fechaIni   =  Carbon::CreateFromFormat('d/m/Y H:i:s', $request->input('fechaIni').' 00:00:00');
        }
        else{
            $fechaIni   = Carbon::now()->startOfMonth();
        }
        if(!empty($fechaFin)){
            $fechaFin =  Carbon::CreateFromFormat('d/m/Y H:i:s', $request->input('fechaFin').' 23:59:59');
        }
        else{
            $fechaFin   = Carbon::now()->endOfMonth();
        }

        return Excel::download(new ReporteCorteCajaExport($fechaIni,$fechaFin), 'reporte_corte_caja_'.$fecha.'.xlsx');
    }

    public function concentrado_pagos_por_mes( Request $request){

        $idStatus           = $request->get('idStatus');
        $txtBuscar          = $request->get('txtBuscar');
        $yearIni            = $request->get('yearIni');

        if(empty($yearIni)){
            $yearIni = '2024';
        }

       $fechaInicial = Carbon::create($yearIni, 1, 1)->startOfMonth();
       $reporte = Pago::getReportePagosPorMesApartir($fechaInicial,$txtBuscar, $idStatus);

        return view('admin.reportes.pagos_por_mes_a_partir', [
            'meses'      => $reporte['meses'],
            'data'       => $reporte['data'],
            'idStatus'   => $idStatus,
            'txtBuscar'  => $txtBuscar,
            'yearIni'    => $yearIni,

        ]);


    }

    public function concentrado_pagos_por_mes_export( Request $request){

        $fecha              = Carbon::now();

        $idStatus           = $request->get('idStatus');
        $txtBuscar          = $request->get('txtBuscar');
        $yearIni            = $request->get('yearIni');

        return Excel::download(new ReporteConcentradoPagosPorMesExport($idStatus,$txtBuscar,$yearIni), 'reporte_concentrado_pagos_'.$fecha.'.xlsx');



    }

    public function pagos_pendientes(Request $request)
    {

        Carbon::setLocale('es');

        $hoy            = Carbon::today();
        $finMes         = $hoy->copy()->endOfMonth();
        $estatusFiltro  = $request->get('estatus');

        $usuarios = User::query()
            ->where('eliminado', 0)
            ->get()
            ->map(function ($usuario) use ($hoy, $finMes) {
                $vigencia = $usuario->fechaVigencia ? Carbon::parse($usuario->fechaVigencia)->startOfDay() : null;

                if (!$vigencia) {
                    $usuario->estatus_pago          = 'Sin vigencia';
                    $usuario->dias_referencia       = null;
                } elseif ($vigencia->lt($hoy)) {
                    $usuario->estatus_pago          = 'Vencido';
                    $usuario->dias_referencia =      $vigencia->diffInDays($hoy);
                } elseif ($vigencia->equalTo($hoy)) {
                    $usuario->estatus_pago          = 'Vence hoy';
                    $usuario->dias_referencia       = 0;
                } elseif ($vigencia->equalTo($hoy->copy()->addDay())) {
                    $usuario->estatus_pago          = 'Vence mañana';
                    $usuario->dias_referencia       = 1;
                } elseif ($vigencia->lte($finMes)) {
                    $usuario->estatus_pago          = 'Vence pronto';
                    $usuario->dias_referencia       = $hoy->diffInDays($vigencia);
                } else {
                    $usuario->estatus_pago          = 'Vigente';
                    $usuario->dias_referencia       = $hoy->diffInDays($vigencia);
                }

                return $usuario;
            });


        $basePendientes = $usuarios->filter(function ($usuario) {
            return in_array($usuario->estatus_pago, [
                'Sin vigencia',
                'Vencido',
                'Vence hoy',
                'Vence mañana',
                'Vence pronto'
            ]);
        });

        if ($estatusFiltro) {
            $estatusFiltro = trim($estatusFiltro);

            $basePendientes = $basePendientes->filter(function ($usuario) use ($estatusFiltro) {
                return trim($usuario->estatus_pago) === $estatusFiltro;
            });
        }

        $pendientes = $basePendientes
            ->sortBy(function ($usuario) {
                $prioridad = match ($usuario->estatus_pago) {
                    'Vence hoy'         => 1,
                    'Vence mañana'      => 2,
                    'Vence pronto'      => 3,
                    'Vencido'           => 4,
                    'Sin vigencia'      => 5,
                    default             => 6,
                };

                $ordenSecundario = match ($usuario->estatus_pago) {
                    'Vence hoy'                     => 0,
                    'Vence mañana', 'Vence pronto'  => $usuario->dias_referencia ?? 9999,
                    'Vencido'                       => $usuario->dias_referencia ?? 9999, // pocos días vencido primero
                    'Sin vigencia'                  => 9999,
                    default                         => 9999,
                };

                return [$prioridad, $ordenSecundario];
            })
            ->values();


        $totalMiembros = $usuarios->count();

        $totalVenceHoy = $usuarios->where('estatus_pago', 'Vence hoy')->count();
        $totalVenceManana = $usuarios->where('estatus_pago', 'Vence mañana')->count();
        $totalVencePronto = $usuarios->where('estatus_pago', 'Vence pronto')->count();
        $totalVencidos = $usuarios->where('estatus_pago', 'Vencido')->count();
        $totalSinVigencia = $usuarios->where('estatus_pago', 'Sin vigencia')->count();
        $totalVigentes = $usuarios->where('estatus_pago', 'Vigente')->count();

        return view('admin.reportes.pagos_pedientes', compact(
            'pendientes',
            'totalMiembros',
            'totalVenceHoy',
            'totalVenceManana',
            'totalVencePronto',
            'totalVencidos',
            'totalSinVigencia',
            'totalVigentes'
        ));
    }

    public function pagos_pendientes_exportar(Request $request)
    {
        Carbon::setLocale('es');

        $hoy = Carbon::today();
        $finMes = $hoy->copy()->endOfMonth();
        $estatusFiltro = $request->get('estatus');

        $usuarios = User::query()
            ->where('eliminado', 0)
            ->get()
            ->map(function ($usuario) use ($hoy, $finMes) {
                $vigencia = $usuario->fechaVigencia ? Carbon::parse($usuario->fechaVigencia)->startOfDay() : null;

                if (!$vigencia) {
                    $usuario->estatus_pago = 'Sin vigencia';
                    $usuario->dias_referencia = null;
                } elseif ($vigencia->lt($hoy)) {
                    $usuario->estatus_pago = 'Vencido';
                    $usuario->dias_referencia = $vigencia->diffInDays($hoy);
                } elseif ($vigencia->equalTo($hoy)) {
                    $usuario->estatus_pago = 'Vence hoy';
                    $usuario->dias_referencia = 0;
                } elseif ($vigencia->equalTo($hoy->copy()->addDay())) {
                    $usuario->estatus_pago = 'Vence mañana';
                    $usuario->dias_referencia = 1;
                } elseif ($vigencia->lte($finMes)) {
                    $usuario->estatus_pago = 'Vence pronto';
                    $usuario->dias_referencia = $hoy->diffInDays($vigencia);
                } else {
                    $usuario->estatus_pago = 'Vigente';
                    $usuario->dias_referencia = $hoy->diffInDays($vigencia);
                }

                return $usuario;
            });

        /*
        |--------------------------------------------------------------------------
        | BASE DE PENDIENTES
        |--------------------------------------------------------------------------
        */
        $basePendientes = $usuarios->filter(function ($usuario) {
            return in_array($usuario->estatus_pago, [
                'Sin vigencia',
                'Vencido',
                'Vence hoy',
                'Vence mañana',
                'Vence pronto'
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | FILTRO POR ESTATUS
        |--------------------------------------------------------------------------
        */
        if ($estatusFiltro) {
            $estatusFiltro = trim($estatusFiltro);

            $basePendientes = $basePendientes->filter(function ($usuario) use ($estatusFiltro) {
                return trim($usuario->estatus_pago) === $estatusFiltro;
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ORDEN
        |--------------------------------------------------------------------------
        */
        $pendientes = $basePendientes
            ->sortBy(function ($usuario) {
                $prioridad = match ($usuario->estatus_pago) {
                    'Vence hoy'    => 1,
                    'Vence mañana' => 2,
                    'Vence pronto' => 3,
                    'Vencido'      => 4,
                    'Sin vigencia' => 5,
                    default        => 6,
                };

                $ordenSecundario = match ($usuario->estatus_pago) {
                    'Vence hoy'                    => 0,
                    'Vence mañana', 'Vence pronto' => $usuario->dias_referencia ?? 9999,
                    'Vencido'                      => $usuario->dias_referencia ?? 9999,
                    'Sin vigencia'                 => 9999,
                    default                        => 9999,
                };

                return [$prioridad, $ordenSecundario];
            })
            ->values();

        return Excel::download(
            new ReportePagosPendientesExport($pendientes),
            'pagos_pendientes_' . now()->format('Y_m_d_His') . '.xlsx'
        );
    }

}
