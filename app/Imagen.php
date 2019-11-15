<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Imagen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];


    public function sublimaciones()
    {
        return $this->hasMany(Sublimacion::class);
    }


    public function tipoImagen()
    {
        return $this->belongsTo(TipoImagen::class, 'tipoImagen_id');
    }
}
