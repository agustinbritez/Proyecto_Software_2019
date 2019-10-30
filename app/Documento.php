<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Documento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;
    protected $guarded = [];
    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
