<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagenIndividual extends Model
{
    public function materiasPrimas()
   {

      return $this->belongsToMany(MateriaPrima::class);
   }

   public function modelos()
   {

      return $this->belongsToMany(Modelo::class);
   }

   public function componentes()
   {

      return $this->belongsToMany(Componente::class);
   }
   public function productos()
   {

      return $this->belongsToMany(Producto::class);
   }
}
