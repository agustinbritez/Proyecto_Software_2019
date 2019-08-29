<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extraccion extends Model
{
    //protected $table="extraccions";
    public function materiasPrimas(){
        return $this->belongsTo(MateriaPrima::class);
    }
}
