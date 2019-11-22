<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FlujoTrabajo extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   use SoftDeletes;
   protected $guarded = [];

   public function modelos()
   {

      return $this->hasMany(Modelo::class, 'flujoTrabajo_id');
   }



   public function pedidos()
   {

      return $this->hasMany(Pedido::class);
   }


   public function transiciones()
   {
      return $this->hasMany(Transicion::class, 'flujoTrabajo_id');
   }


   public function getEstadoInicial()
   {
      foreach ($this->transiciones as $key => $transicion) {
         # code...
         if (is_null($transicion->estadoInicial)) {
            return $transicion->estadoFinal;
         }
      }
      $sinEstado = new Estado();
      $sinEstado->estado = 'SIN ESTADO';
      return $sinEstado;
   }

   public function getEstados()
   {

      $estados = collect();

      foreach ($this->transiciones as $transicion) {
         $estado = $transicion->estadoInicial;
         if (!$estados->contains($estado)) {
            $estados->push($estado);
         }
         $estado = $transicion->estadoFinal;
         if (!$estados->contains($estado)) {
            $estados->push($estado);
         }
      }

      return $estados;
   }


   public function siguienteEstado(Estado $estado)
   {
      $transiciones = $this->transiciones;
      foreach ($transiciones as  $transicion) {
         if ($transicion->estadoInicial == $estado) {
            return $transicion->estadoFinal;
         }
      }
      return null;
   }
   public function estadoAnterior(Estado $estado)
   {
      $transiciones = $this->transiciones;
      foreach ($transiciones as  $transicion) {
         if ($transicion->estadoFinal == $estado) {
            return $transicion->estadoInicial;
         }
      }
      return null;
   }


   public function getPosiblesEstados(Estado $estado)
   {
      $transiciones = $this->transiciones;
      $estados = collect();
      foreach ($transiciones as $key => $transicion) {
         if ($transicion->estadoInicial == $estado) {
            $estados->push($transicion->estadoFinal);
         }
      }
      return $estados;
   }

   //obtiene el estado final del flujo
   public function getEstadoFinal()
   {
      $transiciones = $this->transiciones;
      $estadoInicial = $this->getEstadoInicial();
      $transicionesFiltadras = $transiciones;
      $disponible = true;
      foreach ($transicionesFiltadras as $t1 => $tran1) {
         foreach ($transiciones as $t2 => $tran2) {

            if ($tran1->estadoFinal == $tran2->estadoInicial) {
               $disponible = false;
            }
         }
         if (($disponible == true)) {
            return $tran1->estadoFinal;
         }
         $disponible = true;
      }
   }

   public function getTransicionFinal()
   {
      $transiciones = $this->transiciones;
      $transicionesFiltadras = $transiciones;
      $disponible = true;
      foreach ($transicionesFiltadras as $t1 => $tran1) {
         foreach ($transiciones as $t2 => $tran2) {

            if ($tran1->estadoFinal == $tran2->estadoInicial) {
               $disponible = false;
            }
         }
         if ($disponible == true) {
            return $tran1;
         }
         $disponible = true;
      }
   }

   public function existeEstado($estado)
   {
      $transiciones = $this->transiciones;
      foreach ($transiciones as $key => $transicion) {
         # code...
         if (($transicion->estadoFinal->id == $estado->id)) {
            return true;
         }
      }
      return false;
   }

   // public function siguienteEstado(Reclamo $reclamo){
   //     $this->transiciones($reclamo);
   // }
}
