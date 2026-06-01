<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{
    protected $table = 'tbl_pagos';
    protected $primaryKey = 'idPago';

    protected $fillable = [
        'idUsuario',
        'idUsuarioRecepcion',
        'idFormaPago',
        'fechaPago',
        'fechaVigencia',
        'monto',
        'eliminado'
    ];

    public function membresia()
    {
        return $this->belongsTo(\App\Models\Membresia::class, 'idMembresia', 'idMembresia');
    }

    public static function getPagos($idUsuario)
    {

        $pagos = DB::table('tbl_pagos')
            ->join('cat_formas_pago', 'cat_formas_pago.idFormaPago', '=', 'tbl_pagos.idFormaPago')
            ->where('tbl_pagos.eliminado', '=', 0)
            ->where('tbl_pagos.idUsuario', '=', $idUsuario)
            ->select(
                'tbl_pagos.idPago',
                'tbl_pagos.idUsuario',
                'tbl_pagos.idUsuarioRecepcion',
                'tbl_pagos.idFormaPago',
                'cat_formas_pago.formaPago',
                'tbl_pagos.fechaPago',
                'tbl_pagos.fechaVigencia',
                'tbl_pagos.monto',
            )
            ->orderBy('fechaPago','DESC')
            ->orderBy('fechaVigencia','DESC')
            ->get();

        return $pagos;

    }


    public static function getPagosForCorteCaja($fechaIni, $fechaFin)
    {
        $pagos = DB::table('tbl_pagos')
            ->join('cat_formas_pago', 'cat_formas_pago.idFormaPago', '=', 'tbl_pagos.idFormaPago')
            ->join('tbl_usuarios', 'tbl_usuarios.idUsuario', '=', 'tbl_pagos.idUsuario')
            ->where('tbl_pagos.eliminado', '=', 0)
            ->whereBetween('tbl_pagos.fechaPago', array($fechaIni, $fechaFin))
            ->select(
                'tbl_pagos.idPago',
                'tbl_pagos.idUsuario',
                DB::raw("CONCAT_WS(' ',tbl_usuarios.nombre,tbl_usuarios.apellidoPaterno,tbl_usuarios.apellidoMaterno) AS usuario"),
                'tbl_pagos.idUsuarioRecepcion',
                'tbl_pagos.idFormaPago',
                'cat_formas_pago.formaPago',
                'tbl_pagos.fechaPago',
                'tbl_pagos.fechaVigencia',
                'tbl_pagos.monto',
            )
            ->orderBy('fechaPago','DESC')
            ->orderBy('fechaVigencia','DESC')
            ->get();

        return $pagos;

    }
    public static function getMontoTotalPagosForCorteCaja($fechaIni, $fechaFin)
    {
        $totalPagos = DB::table('tbl_pagos')
            ->where('tbl_pagos.eliminado',  0)
            ->whereBetween('tbl_pagos.fechaPago', array($fechaIni, $fechaFin))
            ->sum('monto');

        return $totalPagos;
    }
    public static function getMontoTotalPagosTransferenciaForCorteCaja($fechaIni, $fechaFin)
    {
        $totalPagos = DB::table('tbl_pagos')
            ->where('tbl_pagos.eliminado',  0)
            ->whereBetween('tbl_pagos.fechaPago', array($fechaIni, $fechaFin))
            ->whereIn('tbl_pagos.idFormaPago',  [1,4])
            ->sum('monto');

        return $totalPagos;
    }
    public static function getMontoTotalPagosEfectivoForCorteCaja($fechaIni, $fechaFin)
    {
        $totalPagos = DB::table('tbl_pagos')
            ->where('tbl_pagos.eliminado',  0)
            ->whereBetween('tbl_pagos.fechaPago', array($fechaIni, $fechaFin))
            ->where('tbl_pagos.idFormaPago', '=', 2)
            ->sum('monto');

        return $totalPagos;
    }
    public static function getMontoTotalPagosDepositoForCorteCaja($fechaIni, $fechaFin)
    {
        $totalPagos = DB::table('tbl_pagos')
            ->where('tbl_pagos.eliminado',  0)
            ->whereBetween('tbl_pagos.fechaPago', array($fechaIni, $fechaFin))
            ->where('tbl_pagos.idFormaPago', '=', 3)
            ->sum('monto');

        return $totalPagos;
    }


    public static function getReportePagosPorMesApartir($fechaInicial,$txtBuscar, $idStatus){

        $now = \Carbon\Carbon::now();

        $inicio = $fechaInicial;
        $fin    = Carbon::now()->startOfMonth();

        $meses = [];
        $selects = [
            'u.idUsuario',
            DB::raw("CONCAT_WS(' ', u.nombre, u.apellidoPaterno, u.apellidoMaterno) AS usuario"),
            'u.created_at AS fechaAlta',
            'u.fechaVigencia AS fechaVigencia'
        ];

        $cursor = $inicio->copy();

        while ($cursor <= $fin) {
            $mes    = $cursor->format('Y-m');
            $desde = $cursor->copy()->startOfMonth()->format('Y-m-d H:i:s');
            $hasta = $cursor->copy()->addMonth()->startOfMonth()->format('Y-m-d H:i:s');

            $meses[] = $mes;

            $selects[] = DB::raw("
            COALESCE(SUM( CASE WHEN p.fechaPago >= '{$desde}' AND p.fechaPago < '{$hasta}' THEN p.monto ELSE 0 END), 0) AS `{$mes}`");

            $cursor->addMonth();
        }

        $data = DB::table('tbl_usuarios as u')
            ->leftJoin('tbl_pagos as p', function ($join) use ($inicio) {
                $join->on('p.idUsuario', '=', 'u.idUsuario')
                    ->where('p.eliminado', 0)
                    ->where('p.fechaPago', '>=', $inicio->format('Y-m-d H:i:s'));
            })
            ->where('u.eliminado', 0)

            ->when(!empty($idStatus) && (int)$idStatus === 1, function ($q) use ($now) {
                $q->where('u.fechaVigencia', '>=', $now);
            })
            ->when(!empty($idStatus) && (int)$idStatus === 2, function ($q) use ($now) {
                $q->where(function ($qq) use ($now) {
                    $qq->where('u.fechaVigencia', '<', $now)->orWhereNull('u.fechaVigencia');
                });
            })
            ->when(!empty($txtBuscar), function ($q) use ($txtBuscar) {
                $like = '%' . $txtBuscar . '%';

                $q->where(function ($qq) use ($like) {
                    $qq->where('u.nombre', 'like', $like)
                        ->orWhere('u.apellidoPaterno', 'like', $like)
                        ->orWhere('u.apellidoMaterno', 'like', $like)
                        ->orWhere('u.email', 'like', $like)
                        ->orWhereRaw("CONCAT_WS(' ', u.apellidoPaterno, u.apellidoMaterno, u.nombre) like ?", [$like])
                        ->orWhereRaw("CONCAT_WS(' ', u.nombre, u.apellidoPaterno, u.apellidoMaterno) like ?", [$like]);
                });
            })



            ->select($selects)
            ->groupBy(
                'u.idUsuario',
                'u.nombre',
                'u.apellidoPaterno',
                'u.apellidoMaterno',
                'u.created_at',
                'u.fechaVigencia'
            )
            ->orderBy('u.fechaVigencia','DESC')
            ->orderBy('u.nombre')
            ->orderBy('u.apellidoPaterno')
            ->orderBy('u.apellidoMaterno')
            ->get();

        return [
            'meses' => $meses,
            'data'  => $data,
        ];
    }

}
