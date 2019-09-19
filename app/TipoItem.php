<?php

namespace App;

use App\Http\Controllers\ImagenController;
use Illuminate\Database\Eloquent\Model;

class TipoItem extends Model
{
    protected $guarded= [];


    public function medida()
    {
        return $this->belongsTo(Medida::class,'medida_id');
    }

    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class,'flujoTrabajo_id');
    }
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function categoria()
    {
        return $this->belongsTo(Categoria::class,'categoria_id');
    }
}
