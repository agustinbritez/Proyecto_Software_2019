<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function user (){
        return $this->belongsTo(User::class);
    }
    public function estado (){
        return $this->belongsTo(Estado::class);
    }
    public function items (){
        return $this->belongsTo(Item::class);
    }
    public function materiaPrimas (){
        return $this->belongsToMany(MateriaPrima::class,'materia_prima_id');
    }
    public function sublimacions (){
        return $this->belongsToMany(Sublimacion::class);
    }
    public function imagens (){
        return $this->hasMany(Imagen::class);
    }
    public function detallePedido (){
        return $this->hasMany(DetallePedido::class);
    }
}
