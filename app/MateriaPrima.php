<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriaPrima extends Model
{
   use SoftDeletes;
   // protected $fillable = ['nombre', 'medida_id','tipoMateriaPrima_id','detalle','cantidad','precioUnitario','color'];
   // protected $fillable = ['nombre', 'detalle','cantidad','precioUnitario','color'];
   protected $guarded = [];

   public function setNombreAttribute($value)
   {
      $this->attributes['nombre'] = strtoupper($value);
   }
   
   public function proveedors()
   {

      return $this->belongsToMany(Proveedor::class);
   }


   public function movimientos()
   {

      return $this->hasMany(Movimiento::class);
   }
   
   public function recetas()
   {
      return $this->hasMany(Receta::class);
      // $modelos=collect();
      // foreach ($recetas as $key => $receta) {
      //    $modelos->add($receta->modeloPadre);
      // }
      // return $modelos;
   }


   public function medida()
   {
      return $this->belongsTo(Medida::class, 'medida_id');
   }
   public function productos()
   {

      return $this->belongsToMany(Producto::class);
   }
   public function modelos()
   {
      return $this->belongsToMany(Modelo::class, 'materia_primas_modelos', 'materiaPrima_id', 'modelo_id');
   }
   public function imagenes()
   {

      return $this->belongsToMany(ImagenIndividual::class);
   }
}
