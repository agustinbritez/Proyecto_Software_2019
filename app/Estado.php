<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Estado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];


    public function transiciones()
    {
        return $this->hasMany(Transicion::class, 'estadoFin_id');
    }
    public function Pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
