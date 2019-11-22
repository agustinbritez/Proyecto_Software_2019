<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaPrimaSeleccionada extends Model
{
    protected $guarded = [];

    public function recetaPadre()
    {
        return $this->belongsTo(Receta::class, 'recetaPadre_id');
    }
    public function recetaHijo()
    {
        return $this->belongsTo(Receta::class, 'recetaHijo_id');
    }
    public function detallePedido()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
