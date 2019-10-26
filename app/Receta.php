<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modelo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    public function modeloPadre()
    {
        return $this->belongsTo(Modelo::class, 'modeloPadre_id')->withTrashed();
    }

    public function modeloHijo()
    {
        return $this->belongsTo(Modelo::class, 'modeloHijo_id')->withTrashed();
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class,'materiaPrima_id')->withTrashed();
    }
}
