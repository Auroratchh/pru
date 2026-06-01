<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gasto extends Model
{
    protected $table = 'tbl_gastos';
    protected $primaryKey = 'idGasto';

    protected $fillable = [
        'idUsuario',
        'idTipoGasto',
        'gasto',
        'descripcion',
        'fechaGasto',
        'monto',
        'eliminado'
    ];

    public static function getAllGastos($fechaIni,$fechaFin)
    {

        $gastos = DB::table('tbl_gastos')
            ->join('tbl_usuarios', 'tbl_usuarios.idUsuario', '=', 'tbl_gastos.idUsuario')
            ->join('cat_tipo_gasto', 'cat_tipo_gasto.idTipoGasto', '=', 'tbl_gastos.idTipoGasto')
            ->where('tbl_gastos.eliminado', '=', 0)
            ->whereBetween('tbl_gastos.fechaGasto', array($fechaIni, $fechaFin))
            ->select(
                'tbl_gastos.idGasto',
                'cat_tipo_gasto.tipoGasto',
                DB::raw("CONCAT_WS(' ',tbl_usuarios.nombre,tbl_usuarios.apellidoPaterno,tbl_usuarios.apellidoMaterno) AS usuario"),
                'tbl_gastos.gasto',
                'tbl_gastos.descripcion',
                'tbl_gastos.fechaGasto',
                'tbl_gastos.monto'
            )
            ->orderBy('tbl_gastos.fechaGasto','DESC')
            ->paginate(50);

        return $gastos;

    }
    public static function getAllGastosLike($fechaIni,$fechaFin,$txtBuscar)
    {

        $gastos = DB::table('tbl_gastos')
            ->join('tbl_usuarios', 'tbl_usuarios.idUsuario', '=', 'tbl_gastos.idUsuario')
            ->join('cat_tipo_gasto', 'cat_tipo_gasto.idTipoGasto', '=', 'tbl_gastos.idTipoGasto')
            ->where(function($query) use ($fechaIni, $fechaFin,$txtBuscar) {
                $query->where( 'tbl_gastos.gasto', "LIKE", "%$txtBuscar%")
                    ->where('tbl_gastos.eliminado', '=', 0)
                    ->whereBetween('tbl_gastos.fechaGasto', array($fechaIni, $fechaFin));

            })
            ->orWhere(function($query) use ($fechaIni, $fechaFin,$txtBuscar) {
                $query->where( 'tbl_gastos.descripcion', "LIKE", "%$txtBuscar%")
                    ->where('tbl_gastos.eliminado', '=', 0)
                    ->whereBetween('tbl_gastos.fechaGasto', array($fechaIni, $fechaFin));
            })
            ->select(
                'tbl_gastos.idGasto',
                'cat_tipo_gasto.tipoGasto',
                DB::raw("CONCAT_WS(' ',tbl_usuarios.nombre,tbl_usuarios.apellidoPaterno,tbl_usuarios.apellidoMaterno) AS usuario"),
                'tbl_gastos.gasto',
                'tbl_gastos.descripcion',
                'tbl_gastos.fechaGasto',
                'tbl_gastos.monto'
            )
            ->orderBy('tbl_gastos.fechaGasto','DESC')
            ->paginate(50);

        return $gastos;

    }


    public static function getGastosForCorteCaja($fechaIni, $fechaFin)
    {
        $gastos = DB::table('tbl_gastos')
            ->join('tbl_usuarios', 'tbl_usuarios.idUsuario', '=', 'tbl_gastos.idUsuario')
            ->join('cat_tipo_gasto', 'cat_tipo_gasto.idTipoGasto', '=', 'tbl_gastos.idTipoGasto')
            ->where('tbl_gastos.eliminado', '=', 0)
            ->whereBetween('tbl_gastos.fechaGasto', array($fechaIni, $fechaFin))
            ->select(
                'tbl_gastos.idGasto',
                'tbl_gastos.idTipoGasto',
                'cat_tipo_gasto.tipoGasto',
                'tbl_gastos.idUsuario',
                DB::raw("CONCAT_WS(' ',tbl_usuarios.nombre,tbl_usuarios.apellidoPaterno,tbl_usuarios.apellidoMaterno) AS usuario"),
                'tbl_gastos.gasto',
                'tbl_gastos.descripcion',
                'tbl_gastos.fechaGasto',
                'tbl_gastos.monto'
            )
            ->orderBy('tbl_gastos.fechaGasto','DESC')
            ->get();

        return $gastos;
    }
    public static function getMontoTotalGastosForCorteCaja($fechaIni, $fechaFin)
    {
        $totalGastos = DB::table('tbl_gastos')
            ->where('tbl_gastos.eliminado', '=', 0)
            ->whereBetween('tbl_gastos.fechaGasto', array($fechaIni, $fechaFin))
            ->sum('monto');

        return $totalGastos;
    }

}
