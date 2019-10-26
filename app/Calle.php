<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calle extends Model
{
  
    use SoftDeletes;
    protected $guarded= [];
  
    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }    
}
