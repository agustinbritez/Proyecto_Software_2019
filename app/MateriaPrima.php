<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    
    public function extracciones(){
        return $this->hasMany(Extraccion::class);

    }

}
