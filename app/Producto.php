<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Producto extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //las relaciones de los procutos con las recetas son siempre con una receta que tiene relacion con una materiaprimas
    public function materiasPrimas()
    {
        $array = collect();
        $recetas = $this->recetas();
        foreach ($recetas as $key => $receta) {
            # code...

            if ($receta != null) {
                if ($receta->materiaPrima != null) {
                    # code...
                    $array->add($receta->materiaPrima);
                }
            }
        }
        return $array;
    }
    // //las materias primas que se utilizan para un producto
    // public function recetas()
    // {
    //     return $this->belongsToMany(Receta::class, 'productos_recetas',  'producto_id', 'receta_id')->where('recetas.deleted_at', null);
    // }

    public function sublimaciones()
    {
        return $this->hasMany(Sublimacion::class);
    }
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
    public function detallePedido()
    {
        return $this->hasMany(DetallePedido::class);
    }
    public function imagenes()
    {

        return $this->belongsToMany(ImagenIndividual::class);
    }
    public function materiaPrimaSeleccionadas()
    {
        return $this->hasMany(MateriaPrimaSeleccionada::class, 'producto_id');
    }
    public function cantidadImagenes()
    {
        # code...
        if ($this->sublimaciones->isEmpty()) {
            return 0;
        }
        $contar = 0;
        foreach ($this->sublimaciones as $key => $sublimacion) {
            # code...
            $contar++;
        }
        return $contar;
    }
}
