<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modelo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Receta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = [];
    public function modeloPadre()
    {
        // return $this->belongsTo(Modelo::class, 'modeloPadre_id');
        return $this->belongsTo(Modelo::class, 'modeloPadre_id');
    }

    public function modeloHijo()
    {
        return $this->belongsTo(Modelo::class, 'modeloHijo_id');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materiaPrima_id');
    }
    public function modeloPadreTodos()
    {
        // return $this->belongsTo(Modelo::class, 'modeloPadre_id');
        return $this->belongsTo(Modelo::class, 'modeloPadre_id')->withTrashed();
    }

    public function modeloHijoTodos()
    {
        return $this->belongsTo(Modelo::class, 'modeloHijo_id')->withTrashed();
    }

    public function materiaPrimaTodos()
    {
        return $this->belongsTo(MateriaPrima::class, 'materiaPrima_id')->withTrashed();
    }
}
