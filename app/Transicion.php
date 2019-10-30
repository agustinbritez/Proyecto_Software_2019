<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class Transicion extends Model implements Auditable
{ 
   use \OwenIt\Auditing\Auditable;
   use SoftDeletes;
   protected $guarded = [];
   
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
