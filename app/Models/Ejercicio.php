<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCarga extends Model
{
    protected $table = 'cat_ejercicio';
    protected $primaryKey = 'idEjercicio';

    protected $fillable = [
        'idCategoriaZona',
        'idCategoriaMov',
        'idCategoriaCarga',
        'idEtapas',
        'ejercicio',
        'descripcion',
    ];

    public function ejercicios(){
        return $this->hasMany(Ejercicio::class, 'idEjercicio', 'idEjercicio');
    }
    public function categoriaZona(){
        return $this->hasMany(Ejercicio::class, 'idCategoriaZona', 'idCategoriaZona');
    }
    public function categoriaCarga(){
        return $this->hasMany(Ejercicio::class, 'idCategoriaCarga', 'idCategoriaCarga');
    }
    public function categoriaMov(){
        return $this->hasMany(Ejercicio::class, 'idCategoriaMov', 'idCategoriaMov');
    }
    public function etapas(){
        return $this->hasMany(Ejercicio::class, 'idEtapas', 'idEtapas');
    }


}