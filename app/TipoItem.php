<?php

namespace App;

use App\Http\Controllers\ImagenController;
use Illuminate\Database\Eloquent\Model;

class TipoItem extends Model
{
    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class);
    }
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
