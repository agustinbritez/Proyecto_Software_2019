<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
   // protected $fillable = ['nombre', 'medida_id','tipoMateriaPrima_id','detalle','cantidad','precioUnitario','color'];
   // protected $fillable = ['nombre', 'detalle','cantidad','precioUnitario','color'];
   protected $guarded= [];
  
   public function proveedors()
   {

      return $this->belongsToMany(Proveedor::class);
   }

  
   public function movimientos()
   {

      return $this->hasMany(Movimiento::class);
   }


   public function medida()
   {

      return $this->belongsTo(Medida::class,'medida_id');
   }
   public function productos()
   {

      return $this->belongsToMany(Producto::class);
   }
   public function modelos()
   {
      return $this->belongsToMany(Modelo::class,'materia_primas_modelos','materiaPrima_id','modelo_id');
   }
   public function imagenes()
   {

      return $this->belongsToMany(ImagenIndividual::class);
   }
}
