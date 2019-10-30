<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Direccion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    // protected $table='direcciones';
    protected $guarded = [];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function proveedors()
    {
        return $this->hasMany(Proveedor::class);
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
    public function calle()
    {
        return $this->belongsTo(Calle::class);
    }
}
