<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function flujoTrabajo(){
        return $this->belongsTo(FlujoTrabajo::class);
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }
    public function detallePedidos(){
        return $this->hasMany(DetallePedido::class);
    }
}
