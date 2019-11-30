<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Pedido extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class, 'flujoTrabajo_id');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id')->where('deleted_at', null);
    }
    public function getPrecio()
    {
        $precioTotal = 0.0;
        foreach ($this->detallePedidos as $key => $detalle) {
            # code...
            if ($detalle != null) {
                $precioTotal += $detalle->producto->modelo->precioUnitario * $detalle->cantidad;
            }
        }
        return $precioTotal;
    }
    public function getFechaPago()
    {
        $fecha = Carbon::create($this->fechaPago)->format('d/m/Y');
        return $fecha;
    }
    public function getCambioEstado()
    {
        $fecha = Carbon::create($this->cambioEstado)->format('d/m/Y');
        return $fecha;
    }
    public function getCantidadProductos()
    {
        $cantidadProductos = 0;

        foreach ($this->detallePedidos as $key => $detalle) {
            # code...
            $cantidadProductos += $detalle->cantidad;
        }

        return $cantidadProductos;
    }
    //si existe algun detalle de pedido que no esta en estado final no puede terminar
    public function puedeTerminar()
    {
        # code...
        foreach ($this->detallePedidos as $key => $detalle) {
            # code...
            if ($detalle->getEstadoFinal()->id != $detalle->estado->id) {
                return false;
            }
        }
        return true;
    }
    public function restarMateriaPrimas()
    {
        foreach ($this->detallePedidos as $key => $detalle) {
            $detalle->producto->modelo->restarMateriaPrima($detalle->cantidad, $detalle->producto->materiaPrimaSeleccionadas);
        }
        return true;
    }
   
}
