<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCarga extends Model
{
    protected $table = 'cat_categoria_zona';
    protected $primaryKey = 'idCategoriaZona';

    protected $fillable = [
        'tipoZona',
        'descripcion',
    ];

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class, 'idCategoriaZona', 'idCategoriaZona');
    }
}