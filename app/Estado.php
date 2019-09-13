<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function transicions()
    {
        return $this->hasMany(Transicion::class);
    }
    public function Pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
