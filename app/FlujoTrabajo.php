<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlujoTrabajo extends Model
{
    public function modelos()
    {
 
       return $this->hasMany(Modelo::class);
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
