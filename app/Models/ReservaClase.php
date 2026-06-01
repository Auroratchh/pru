<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReservaClase extends Model
{
    protected $table = 'tbl_reservas_clases';
    protected $primaryKey = 'idReservaClase';

    protected $fillable = [
        'idUsuario',
        'idClaseBloque',
        'fechaClase',
        'fechaReserva',
        'estatus',
    ];

    protected $casts = [
        'fechaClase' => 'date',
        'fechaReserva' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'idUsuario');
    }

    public function bloque()
    {
        return $this->belongsTo(\App\Models\ClaseBloque::class, 'idClaseBloque', 'idClaseBloque');
    }

    public function asistencia()
    {
        return $this->hasOne(Asistencia::class, 'idReservaClase', 'idReservaClase');
    }

    public function getFechaClaseTextoAttribute()
    {
        if (!$this->fechaClase) {
            return '';
        }

        return Carbon::parse($this->fechaClase)->translatedFormat('d \d\e F \d\e Y');
    }
    public function getBadgeReservaClassAttribute()
    {
        return match ($this->estatus) {
            'reservada' => 'badge-status-warning',
            'asistio' => 'badge-status-success',
            'cancelada' => 'badge-status-secondary',
            'no_asistio' => 'badge-status-danger',
            default => 'badge-status-secondary',
        };
    }
    public function getEstatusTextoAttribute()
    {
        return match ($this->estatus) {
            'reservada' => 'Reservada',
            'asistio' => 'Asistió',
            'cancelada' => 'Cancelada',
            'no_asistio' => 'No asistió',
            default => ucfirst($this->estatus),
        };
    }
}