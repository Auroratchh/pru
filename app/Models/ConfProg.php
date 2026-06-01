<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCarga extends Model
{
    protected $table = 'conf_prog';
    protected $primaryKey = 'idConfProg';

    protected $fillable = [
        'idProgramacion',
        'idEtapas',
        'tiposEntrenamientos',
        'descripcion',
        'rounds',
        'tiempoTotal',
        'tiempoTrabajo',
        'tiempoDescanso',
        'tiempoEj',
        'repInicio',
        'repEj',
    ];

    public function ejercicios(){
        return $this->hasMany(Ejercicio::class, 'idConfProg', 'idConfProg');
    }
    public function programacion(){
        return $this->hasMany(Ejercicio::class, 'idProgramacion', 'idProgramacion');
    }
    public function etapas(){
        return $this->hasMany(Ejercicio::class, 'idEtapas', 'idEtapas');
    }

}