<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Medida extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;
    protected $guarded = [];

    function materiaPrimas()
    {
        return $this->hasMany(MateriaPrima::class);
    }

    function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
