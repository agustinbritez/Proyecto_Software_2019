<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Provincia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;
    protected $guarded= [];
  
    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }
}
