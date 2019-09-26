<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modelo;
class Receta extends Model
{
    public function modeloPadre()
    {
        return $this->belongsTo(Modelo::class,'modeloPadre_id');
    }

    public function modeloHijo()
    {
        return $this->belongsTo(Modelo::class,'modeloHijo_id');
    }
}
