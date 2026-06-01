<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Etapa extends Model
{
    protected $table = 'cat_etapas';
    protected $primaryKey = 'idEtapas';
 
    protected $fillable = [
        'nombre',
        'activo',
    ];
 
    public function ejercicios(){
        return $this->hasMany(Ejercicio::class, 'idEtapas', 'idEtapas');
    }

}
