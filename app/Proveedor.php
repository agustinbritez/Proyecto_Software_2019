<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    public function documents (){
        return $this->hasMany(Documento::class);
    }

    public function direccions (){
        return $this->belongsToMany(Direccion::class);
    }
    public function movimientos (){
        return $this->hasMany(Movimiento::class);
    }
    public function items (){
        return $this->belongsToMany(Item::class);
    }

}
