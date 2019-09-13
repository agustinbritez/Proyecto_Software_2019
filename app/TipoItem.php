<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoItem extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function flujoTrabajos()
    {
        return $this->hasMany(FlujoTrabajo::class);
    }
}
