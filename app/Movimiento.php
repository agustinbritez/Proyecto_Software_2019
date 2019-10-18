<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
use SoftDeletes;
protected $guarded= [];

    public function tipoMovimiento(){
        return $this->belongsTo(TipoMovimiento::class);
    }
    
    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
    
    public function materiaPrima(){
        return $this->belongsTo(MateriaPrima::class);
    }

    public function getFechaMovimiento(){
        $fecha= Carbon::create($this->fecha)->format('d/m/Y');
        return $fecha;
    }

    public function getHoraMovimiento(){
        $fecha= Carbon::create($this->fecha)->format('H:i:s');
        return $fecha;
    }
}
