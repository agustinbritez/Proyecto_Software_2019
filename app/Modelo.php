<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    
    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class,'materia_primas_modelos','modelo_id','materiaPrima_id');
    }

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function productosModelos()
    {
        return $this->hasMany(Producto::class);
    }
    public function imagenes()
   {

      return $this->belongsToMany(ImagenIndividual::class);
   }

}
