<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Proveedor extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];


    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
    public function materiaPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class);
    }
}
