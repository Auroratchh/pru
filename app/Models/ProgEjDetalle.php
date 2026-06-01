<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCarga extends Model
{
    protected $table = 'prog_ej_detalle';
    protected $primaryKey = 'idDetalle';

    protected $fillable = [
        'idConfProg',
        'idEjercicio',
        'orden',
        'series',
        'reps',
        'pesoFinal',
        'pesoInicial',
        'nota',
    ];

    public function detalle(){
        return $this->belongsTo(detalleConfiguracion::class, 'idDetalle', 'idDetalle');
    }
    public function confProg(){
        return $this->belongsTo(configuracion::class, 'idConfProg', 'idConfProg');
    }
    public function ejercicio(){
        return $this->belongsTo(Ejercicio::class, 'idEjercicio', 'idEjercicio');
    }

}