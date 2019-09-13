<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    public function componentes()
    {
        return $this->belongsToMany(Componente::class);
    }
    public function sublimacions()
    {
        return $this->hasMany(Sublimacion::class);
    }
    public function producto (){
        return $this->belongsTo(Producto::class);
    }
    public function user (){
        return $this->belongsTo(User::class);
    }
}
