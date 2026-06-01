<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    protected $table = 'programacion';
    protected $primaryKey = 'idProgramacion';

    protected $fillable = [
        'idUsuario',
        'fecha',
        'diaPlan',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'idUsuario', 'idUsuario');
    }

    public function configuraciones(){
        return $this->hasMany(ConfProg::class, 'idProgramacion', 'idProgramacion');
    }

    public function getDiaPlanTextoAttribute()
    {
        return match($this->diaPlan) {
            'LUNES'  => 'Lunes',
            'MARTES' => 'Martes',
            'MIERCOLES' => 'Miércoles',
            'JUEVES'  => 'Jueves',
            'VIERNES' => 'Viernes',
            'SABADO' => 'Sábado',
            default  => $this->diaPlan,
        };
    }
}