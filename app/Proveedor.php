<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $fillable = [

        'nombre', 'email','razonSocial'

    ];
    // protected $guarded= [];
    public function documentos (){
        return $this->hasMany(Documento::class);
    }

    public function direcciones (){
        return $this->belongsToMany(Direccion::class);
    }
    public function movimientos (){
        return $this->hasMany(Movimiento::class);
    }
    public function materiaPrimas()
    {
 
       return $this->belongsToMany(MateriaPrima::class);
    }

}
