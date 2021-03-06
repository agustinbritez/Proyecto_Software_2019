<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Configuracion extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function direccion()
    {
        # code...
        return $this->belongsTo(Direccion::class);
    }
}
