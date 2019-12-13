<?php

namespace App;

use App\Http\Controllers\MovimientoController;
use Carbon\Carbon;
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

   public function proveedores()
   {

      return $this->belongsToMany(Proveedor::class, 'propuesta_materia_primas', 'materiaPrima_id', 'proveedor_id')->where('propuesta_materia_primas.deleted_at', null);
   }

   public function propuestaMateriaPrimas()
   {

      return $this->hasMany(PropuestaMateriaPrima::class, 'materiaPrima_id');
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
   public function restarMateriaPrima($cantidad, $detallePedido)
   {
      # code...
      $tipo = TipoMovimiento::where('nombre', 'VENTA')->first();
      $movimiento = new Movimiento();
      $movimiento->cantidad = $cantidad;
      $movimiento->precioUnitario = $this->precioUnitario;
      $movimiento->fecha = Carbon::now();
      $movimiento->user_id = $detallePedido->pedido->user_id;
      $movimiento->tipoMovimiento_id = $tipo->id;
      $movimiento->materiaPrima_id = $this->id;
      $movimiento->save();

      $this->cantidad = $this->cantidad - $cantidad;
      if($this->cantidad <= $this->stockMinimo){
         $propuestas= PropuestaMateriaPrima::all()->where('materiaPrima_id',$this->id);
         foreach ($propuestas as $key => $propuesta) {
            # code...
            $propuesta->realizado=0;
            $propuesta->update();
         }
      }
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
