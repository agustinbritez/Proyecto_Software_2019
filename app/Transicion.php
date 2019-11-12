<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Transicion extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;

   protected $guarded = [];

   public function flujoTrabajo()
   {

      return $this->belongsTo(FlujoTrabajo::class);
   }

   public function estadoInicial()
   {

      return $this->belongsTo(Estado::class, 'estadoInicio_id');
   }

   public function estadoFinal()
   {

      return $this->belongsTo(Estado::class, 'estadoFin_id');
   }
}
