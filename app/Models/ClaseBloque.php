<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClaseBloque extends Model
{
    protected $table = 'tbl_clases_bloques';
    protected $primaryKey = 'idClaseBloque';

    protected $fillable = [
        'nombreClase',
        'tipoDia',
        'horaInicio',
        'horaFin',
        'cupoMaximo',
        'activo',
        'orden',
    ];

    public function reservas()
    {
        return $this->hasMany(ReservaClase::class, 'idClaseBloque', 'idClaseBloque');
    }

    public function getHoraTextoAttribute()
    {
        $inicio = Carbon::parse($this->horaInicio)->format('g:i A');

        if (!$this->horaFin) {
            return $inicio;
        }

        $fin = Carbon::parse($this->horaFin)->format('g:i A');

        return $inicio . ' - ' . $fin;
    }
}