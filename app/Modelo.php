<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    //obtiene la receta donde es el padre
    public function recetaPadre()
    {
        return $this->hasMany(Receta::class, 'modeloPadre_id');
    }
    //obtiene la recetas donde el es un ingrediente
    public function recetaHijo()
    {
        return $this->hasMany(Receta::class, 'modeloHijo_id');
    }

    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class, 'materia_primas_modelos', 'modelo_id', 'materiaPrima_id');
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
    public function medida()
    {
        return $this->belongsTo(Medida::class, 'medida_id');
    }
}
