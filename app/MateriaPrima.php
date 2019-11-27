<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MateriaPrima extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
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
      return $this->hasMany(Receta::class, 'materiaPrima_id');
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
      return $this->belongsToMany(Producto::class, 'recetas', 'materiaPrima_id', 'producto_id');
   }
   public function modelos()
   {
      return $this->belongsToMany(Modelo::class, 'recetas', 'materiaPrima_id', 'modeloPadre_id')->where('recetas.deleted_at', null);
   }
   public function imagenes()
   {

      return $this->belongsToMany(ImagenIndividual::class);
   }
   public function aumentarMateriaPrima()
   {
      $this->cantidad;
   }
   public function restarMateriaPrima($cantidad)
   {
      # code...
      $this->cantidad = $this->cantidad - $cantidad;
      $this->update();
   }
   public function pruebaDeResta($cantidad)
   {
      # code...
      $aux = $this->cantidad - $cantidad;
      if ($aux < 0) {
         return [$this];
      }
      return [];
   }
}
