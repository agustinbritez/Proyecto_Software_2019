<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
