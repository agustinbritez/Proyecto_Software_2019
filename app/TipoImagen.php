<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class TipoImagen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    
    public function tipoImagenes()
    {
        return $this->hasMany(TipoImagen::class);
    }
}
