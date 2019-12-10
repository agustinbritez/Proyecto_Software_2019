<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DetallePedido extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    // public function recetaHijos()
    // {
    //     return $this->belongsToMany(Receta::class, 'detalle_pedidos_recetas', 'detallePedido_id', 'receta_id')->where('recetas.deleted_at', null);
    // }

    public function recetasPadres()
    {
        return $this->belongsToMany(Receta::class, 'materia_prima_seleccionadas', 'detallePedido_id', 'recetaPadre_id');
    }



    public function getFechaPago()
    {
        if (is_null($this->fechaPago)) {
            return null;
        }
        return Carbon::create($this->fechaPago)->format('d/m/Y');
    }

    public function getUltimaAtualizacion()
    {
        if (is_null($this->updated_at)) {
            return null;
        }
        return $this->updated_at->diffForHumans();
    }

    public function getEstadoFinal()
    {
        return $this->producto->modelo->flujoTrabajo->getEstadoFinal();
    }


    //obtiene la cantidad de dias que estuvo el producto desde que se pago hasta que se termino
    public function getDiasEnProduccion()
    {
        # code...
        $fechaPago = new Carbon($this->fechaInicioProduccion);
        $fechaTerminado = new Carbon($this->fechaTerminado);
        //le sumo uno porque si la diferencia es 0 significa que se hizo todo en el mismo dia
        return $fechaPago->diffInDays($fechaTerminado) + 1;
    }
}
