<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'cat_formas_pago';
    protected $primaryKey = 'idFormaPago';

    protected $fillable = [
        'formaPago',
        'eliminado'
    ];

}
