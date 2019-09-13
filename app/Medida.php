<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    function materiaPrimas(){
        return $this->hasMany(MateriaPrima::class);
    }
}
