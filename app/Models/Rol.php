<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'cat_roles';
    protected $primaryKey = 'idRol';

    protected $fillable = [
        'rol',
        'eliminado'
    ];

}
