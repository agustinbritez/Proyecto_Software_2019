<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
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
