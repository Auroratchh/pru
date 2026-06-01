<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCarga extends Model
{
    protected $table = 'tbl_marca_usuarios';
    protected $primaryKey = 'idMarca';

    protected $fillable = [
        'idUsuario',
        'idConfProg',
        'resultadoTiempo',
        'fecha',
        'resultadoReps',
        'resultadoPeso',
        'puntosObtenidos',
        'notas',
    ];


    protected $casts = [
        'fecha' => 'date',
    ];
    
    public function marca(){
        return $this->hasMany(Marca::class, 'idMarca', 'idMarca');
    }
    public function usuario(){
        return $this->hasMany(User::class, 'idUsuario', 'idUsuario');
    }
    public function confProg(){
        return $this->hasMany(configuracion::class, 'idConfProg', 'idConfProg');
    }

}