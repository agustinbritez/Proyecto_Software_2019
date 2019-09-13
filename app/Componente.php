<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    public function item(){
        return $this->belongsTo(Item::class);
    } 
    public function imagenes(){
        return $this->belongsToMany(Imagen::class);
    } 
    public function sublimacion(){
        return $this->belongsToMany(Sublimacion::class);
    } 
}
