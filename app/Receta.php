<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modelo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Receta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = [];
    public function modeloPadre()
    {
        // return $this->belongsTo(Modelo::class, 'modeloPadre_id');
        return $this->belongsTo(Modelo::class, 'modeloPadre_id');
    }

    public function modeloHijo()
    {
        return $this->belongsTo(Modelo::class, 'modeloHijo_id');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materiaPrima_id');
    }
    // public function productos()
    // {
    //     return $this->belongsToMany(Producto::class, 'productos_recetas', 'receta_id', 'producto_id')->where('productos.deleted_at', null);
    // }
    // public function detallesPedidos()
    // {
    //     return $this->belongsToMany(DetallePedido::class, 'detalle_pedidos_recetas', 'detallePedido_id', 'receta_id')->where('detalle_pedido.deleted_at', null);
    // }
    //obtienen todas las materias primas seleccionadas donde esta receta es el padre
    public function materiaPrimaSeleccionadasPadre()
    {
        return $this->hasMany(MateriaPrimaSeleccionada::class, 'recetaPadre_id');
    }

    public function materiaPrimaSeleccionadasHijo()
    {
        return $this->hasMany(MateriaPrimaSeleccionada::class, 'recetaHijo_id');
    }

    public function detallesPedidos()
    {
        return $this->belongsToMany(DetallePedido::class, 'materia_prima_seleccionadas',  'recetaPadre_id', 'detallePedido_id');
    }



    public function modeloPadreTodos()
    {
        // return $this->belongsTo(Modelo::class, 'modeloPadre_id');
        return $this->belongsTo(Modelo::class, 'modeloPadre_id')->withTrashed();
    }

    public function modeloHijoTodos()
    {
        return $this->belongsTo(Modelo::class, 'modeloHijo_id')->withTrashed();
    }

    public function materiaPrimaTodos()
    {
        return $this->belongsTo(MateriaPrima::class, 'materiaPrima_id')->withTrashed();
    }
}
