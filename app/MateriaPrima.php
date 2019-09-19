<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
   // protected $fillable = ['nombre', 'medida_id','tipoMateriaPrima_id','detalle','cantidad','precioUnitario','color'];
   // protected $fillable = ['nombre', 'detalle','cantidad','precioUnitario','color'];
   protected $guarded= [];
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

      return $this->belongsTo(TipoMateriaPrima::class,'tipoMateriaPrima_id');
   }

   public function medida()
   {

      return $this->belongsTo(Medida::class,'medida_id');
   }
   public function prductos()
   {

      return $this->belongsToMany(Producto::class);
   }
}
