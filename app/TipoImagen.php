<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoImagen extends Model
{
    public function tipoImagenes()
    {
        return $this->hasMany(TipoImagen::class);
    }
}
