<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    protected $fillable=['nombre','medida'];
    public function extracciones(){
       
       // return $this->hasMany(Extraccion::class,'materia_prima_id');
       return $this->hasMany(Extraccion::class);
    }

}
