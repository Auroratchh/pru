<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'tbl_asistencias';
    protected $primaryKey = 'idAsistencia';

    protected $fillable = [
        'idUsuario',
        'idReservaClase',
        'fechaAsistencia',
        'horaAsistencia',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'idUsuario');
    }

    public function reserva()
    {
        return $this->belongsTo(\App\Models\ReservaClase::class, 'idReservaClase', 'idReservaClase');
    }


    public function getHoraAsistenciaTextoAttribute()
    {
        if (!$this->horaAsistencia) {
            return '-';
        }

        return Carbon::parse($this->horaAsistencia)->format('h:i A');
    }

}
