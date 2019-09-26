<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
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
