<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    protected $table = 'cat_tipo_gasto';
    protected $primaryKey = 'idTipoGasto';

    protected $fillable = [
        'tipoGasto',
        'eliminado'
    ];

}
