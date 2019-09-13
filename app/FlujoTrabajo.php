<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlujoTrabajo extends Model
{
    public function tipoItems()
    {
 
       return $this->hasMany(Item::class);
    }

    public function transicions()
    {
 
       return $this->hasMany(Transicion::class);
    }
    
    public function pedidos()
    {
 
       return $this->hasMany(Pedido::class);
    }
}
