<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
   // protected $table='direcciones';
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function proveedors()
    {
        return $this->belongsToMany(Proveedor::class);
    }
}
