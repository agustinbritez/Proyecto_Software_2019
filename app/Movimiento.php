<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    public function tipoMovimiento(){
        return $this->belongsTo(TipoMovimiento::class);
    }
    
    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
    
    public function materiaPrima(){
        return $this->belongsTo(MateriaPrima::class);
    }
}