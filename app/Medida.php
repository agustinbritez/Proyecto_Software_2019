<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medida extends Model
{

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
