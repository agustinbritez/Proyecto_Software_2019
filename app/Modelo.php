<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Modelo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = [];

    //obtiene la receta donde es el padre
    public function recetaPadre()
    {
        return $this->hasMany(Receta::class, 'modeloPadre_id')->where('deleted_at', null);
    }
    //obtiene la recetas donde el es un ingrediente
    public function recetaHijo()
    {
        return $this->hasMany(Receta::class, 'modeloHijo_id');
    }
    //obtener todos los hijos directo del modelo osea los modelo que le referencian en su receta donde este es el padre.
    public function hijosModelos()
    {
        //primero va el id del objeto este objeto segundo los id de los objetos que quiero traer
        return $this->belongsToMany(Modelo::class, 'recetas', 'modeloPadre_id', 'modeloHijo_id')->where('recetas.deleted_at', null);
    }
    //obtiene todos los modelos que son sus padres osea los padres de diferentes recetas
    public function padresModelos()
    {
        //primero va el id del objeto este objeto segundo los id de los objetos que quiero traer
        return $this->belongsToMany(Modelo::class, 'recetas',  'modeloHijo_id', 'modeloPadre_id')->where('recetas.deleted_at', null);
    }
    //obtiene las materias primas hijas en las receta osea las materias primas que son ingredientes
    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class, 'recetas', 'modeloPadre_id', 'materiaPrima_id')->where('recetas.deleted_at', null);
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
    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class, 'flujoTrabajo_id');
    }

    public function restarMateriaPrima($cantidad)
    {

        # code...
        if (!$this->hijosModelos->isEmpty()) {
            foreach ($this->recetaPadre as $key => $receta) {
                # code...
                if ($receta->modeloHijo != null) {
                    $receta->modeloHijo->restarMateriaPrima($cantidad * $receta->cantidad);
                }
            }
        }
        if (!$this->materiasPrimas->isEmpty()) {
            # code...
            foreach ($this->recetaPadre as $key => $receta) {
                # code...
                if ($receta->materiaPrima != null) {
                    $receta->materiaPrima->restarMateriaPrima($cantidad * $receta->cantidad);
                }
            }
        }
    }
    public function comprobarResta($cantidad)
    {
        $materiaPrimaSinStock = [];
        # code...
        if (!$this->hijosModelos->isEmpty()) {
            foreach ($this->recetaPadre as $key => $receta) {
                # code...
                if ($receta->modeloHijo != null) {
                    $materiaPrimaSinStock = array_merge($materiaPrimaSinStock, $receta->modeloHijo->comprobarResta($cantidad * $receta->cantidad));
                }
            }
        }
        if (!$this->materiasPrimas->isEmpty()) {
            # code...
            foreach ($this->recetaPadre as $key => $receta) {
                # code...
                if ($receta->materiaPrima != null) {
                    $materiaPrimaSinStock = array_merge($materiaPrimaSinStock, $receta->materiaPrima->pruebaDeResta($cantidad * $receta->cantidad));
                }
            }
        }
        return $materiaPrimaSinStock;
    }
}
