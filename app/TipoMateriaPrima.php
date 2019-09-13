<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMateriaPrima extends Model
{
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
    public function materiaPrimas()
    {
        return $this->hasMany(MateriaPrima::class);
    }
}
