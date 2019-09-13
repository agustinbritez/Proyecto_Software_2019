<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sublimacion extends Model
{
    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }
    public function componentes()
    {
        return $this->belongsToMany(Componente::class);
    }
    public function imagen()
    {
        return $this->belongsTo(Imagen::class);
    }
}
