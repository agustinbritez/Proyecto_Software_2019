<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
   
  
    public function sublimaciones()
    {
        return $this->hasMany(Sublimacion::class);
    }

 
    public function tipoImagen (){
        return $this->belongsTo(TipoImagen::class);
    }

}
