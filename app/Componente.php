<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Componente extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
    public function sublimaciones()
    {
        return $this->hasMany(Sublimacion::class);
    }
    public function imagenes()
    {

        return $this->belongsToMany(ImagenIndividual::class);
    }
    //obtiene 
    public function obtenerSublimacionesDelProducto($producto)
    {
        if($producto->sublimaciones->isEmpty()){
            return $producto->sublimaciones;
        }
        return $producto->sublimaciones->where('componente_id',$this->id);

    }
}
