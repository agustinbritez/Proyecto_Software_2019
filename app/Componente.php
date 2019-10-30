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
    
    public function modelo(){
        return $this->belongsTo(Modelo::class);
    } 
    public function sublimacion(){
        return $this->belongsToMany(Sublimacion::class);
    } 
    public function imagenes()
   {

      return $this->belongsToMany(ImagenIndividual::class);
   }
}
