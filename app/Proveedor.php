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
        return $this->belongsToMany(MateriaPrima::class, 'propuesta_materia_primas', 'proveedor_id', 'materiaPrima_id')->where('propuesta_materia_primas.deleted_at', null);

        // return $this->belongsToMany(MateriaPrima::class, 'materia_primas_proveedors', 'proveedor_id', 'materiaPrima_id');
    }
    public function propuestaMateriaPrimas()
    {

        return $this->hasMany(PropuestaMateriaPrima::class, 'proveedor_id');
    }
}
