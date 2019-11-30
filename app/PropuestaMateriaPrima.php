<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PropuestaMateriaPrima extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class,  'materiaPrima_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class,  'proveedor_id');
    }
}
