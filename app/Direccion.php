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
        return $this->belongsToMany(User::class, 'direccion_envios', 'direccion_id', 'user_id');
    }
    public function proveedores()
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
  
    public function direccionEnvios()
    {
        # code...
        return $this->hasMany(DireccionEnvio::class);
    }
    public function configuraciones()
    {
        # code...
        return $this->hasMany(Configuracion::class);
    }
    public function obtenerDireccion()
    {
        # code...
        return $this->pais->nombre . ' - ' . $this->provincia->nombre . ' - ' . $this->localidad->nombre . ' - ' . $this->calle->nombre . '  (' . $this->numero . ')';
    }
    public function obtenerCodigoPostal()
    {
        # code...
        return $this->localidad->codigoPostal;
    }
}
