<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $fillable = [

        'nombre', 'email','razonSocial'

    ];
    // protected $guarded= [];
    

    public function direccion (){
        return $this->belongsTo(Direccion::class);
    }
    public function documento (){
        return $this->belongsTo(Documento::class);
    }
    public function movimientos (){
        return $this->hasMany(Movimiento::class);
    }
    public function materiaPrimas()
    {
       return $this->belongsToMany(MateriaPrima::class);
    }

}
