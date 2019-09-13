<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    public function tipoItem()
    {
        return $this->belongsTo(TipoItem::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function imagens()
    {
        return $this->belongsToMany(Imagen::class);
    }

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function itemRelacions()
    {
        return $this->hasMany(ItemRelacion::class);
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }


}
