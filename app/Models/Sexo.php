<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $table = 'cat_sexos';
    protected $primaryKey = 'idSexo';


    protected $fillable = [
        'sexo',
        'eliminado'
    ];

}
