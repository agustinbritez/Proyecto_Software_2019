<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class FlujoTrabajo extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   use SoftDeletes;
   protected $guarded = [];
   
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
