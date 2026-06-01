<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 'cat_membresias';
    protected $primaryKey = 'idMembresia';

    protected $fillable = [
        'nombre',
        'costo',
        'diasDuracion',
        'descripcion',
        'activo',
    ];


    public function calcularFechaVigencia($fechaPago)
    {
        $fecha = \Carbon\Carbon::parse($fechaPago)->startOfDay();
        $diasDuracion = (int) $this->diasDuracion;

        if ($diasDuracion === 30) {
            return $fecha->copy()->addMonth()->endOfDay();
        }

        return $fecha->copy()->addDays($diasDuracion)->endOfDay();
    }

}
