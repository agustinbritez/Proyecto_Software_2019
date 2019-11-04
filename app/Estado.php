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
    

    public function transicions()
    {
        return $this->hasMany(Transicion::class);
    }
    public function Pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
