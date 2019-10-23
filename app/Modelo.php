<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    //obtiene la receta donde es el padre
    public function recetaPadre()
    {
        return $this->hasMany(Receta::class,'modeloPadre_id');
    }
//obtiene la recetas donde tiene sus ingredientes osea los modelos que son hijos
    public function recetaHijo()
    {
        return $this->hasMany(Receta::class,'modeloHijo_id');
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
