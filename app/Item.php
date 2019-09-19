<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
    
    public function tipoItem()
    {
        return $this->belongsTo(TipoItem::class);
    }

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function imagens()
    {
        return $this->belongsToMany(Imagen::class);
    }

    public function productosModelos()
    {
        return $this->hasMany(Producto::class);
    }

    public function productosPersonalizados()
    {
        return $this->belongsToMany(Producto::class);
    }

   


   


}
