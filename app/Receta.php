<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function tipoMateriaPrima()
    {
        return $this->belongsTo(TipoMateriaPrima::class);
    }
}
