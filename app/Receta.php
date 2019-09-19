<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    public function itemPadre()
    {
        return $this->belongsTo(Item::class,'itemPadre_id');
    }

    public function itemHijo()
    {
        return $this->belongsTo(Item::class,'itemHijo_id');
    }
}
