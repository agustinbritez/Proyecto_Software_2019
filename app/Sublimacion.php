<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Sublimacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
    public function imagen()
    {
        return $this->belongsTo(Imagen::class);
    }
}
