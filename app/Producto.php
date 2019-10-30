<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class Producto extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function user (){
        return $this->belongsTo(User::class);
    }
    public function estado (){
        return $this->belongsTo(Estado::class);
    }
    //las materias primas que se utilizan para un producto
    public function materiaPrimas (){
        return $this->belongsTo(MateriaPrima::class);
    }

    public function sublimacions (){
        return $this->belongsToMany(Sublimacion::class);
    }
    public function modelo (){
        return $this->belongsTo(Modelo::class);
    }
    public function detallePedido (){
        return $this->hasMany(DetallePedido::class);
    }
    public function imagenes()
   {

      return $this->belongsToMany(ImagenIndividual::class);
   }
}
