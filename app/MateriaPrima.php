<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
   protected $fillable = ['nombre', 'medida'];

   public function movimientos()
   {

      return $this->hasMany(Movimiento::class);
   }
   public function proveedors()
   {

      return $this->belongsToMany(Proveedor::class);
   }


   public function tipoMateriaPrima()
   {

      return $this->belongsTo(TipoMateriaPrima::class);
   }

   public function medida()
   {

      return $this->belongsTo(Medida::class);
   }
   public function prductos()
   {

      return $this->belongsToMany(Producto::class);
   }
}
