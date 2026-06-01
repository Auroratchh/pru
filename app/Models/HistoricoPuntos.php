<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCarga extends Model
{
    protected $table = 'tbl_historico_puntos';
    protected $primaryKey = 'idHistorico';

    protected $fillable = [
        'idMarca',
        'idUsuario',
        'puntosActuales',
        'puntosTotalesGanados',
    ];

    public function historico(){
        return $this->hasMany(Marca::class, 'idHistorico', 'idHistorico');
    }
    public function marca(){
        return $this->hasMany(Marca::class, 'idMarca', 'idMarca');
    }
    public function usuario(){
        return $this->belongsTo(Ejercicio::class, 'idUsuario', 'idUsuario');
    }
}