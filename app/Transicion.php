<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transicion extends Model
{
    
    public function flujoTrabajo()
    {
 
       return $this->belongsTo(FlujoTrabajo::class);
    }
    
    public function estadoInicio()
    {
 
       return $this->belongsTo(Estado::class,'estadoInicio_id');
    }
    
    public function estadoFin()
    {
 
       return $this->belongsTo(Estado::class,'estadoFin_id');
    }
}
