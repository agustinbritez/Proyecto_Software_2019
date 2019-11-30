<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Movimiento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipoMovimiento_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materiaPrima_id');
    }

    public function getFechaMovimiento()
    {
        $fecha = Carbon::create($this->fecha)->format('d/m/Y');
        return $fecha;
    }

    public function getHoraMovimiento()
    {
        $fecha = Carbon::create($this->fecha)->format('H:i:s');
        return $fecha;
    }
}
