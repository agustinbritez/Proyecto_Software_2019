<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment\Doc;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];

    use Notifiable;
    use HasRolesAndPermissions;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable= ['nombre','email','apellido','documento','password'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function documento()
    {
        return $this->hasOne(Documento::class);
    }
    public function direccions()
    {
        return $this->belongsToMany(Direccion::class);
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'user_id');
    }
    //obtiene el pedido que no se ha enviado
    public function pedidoAPagar()
    {
        // si el atributo terminado es null significa que no se envio si es 0 se pago pero no se termino
        //si es 1 finalizo el pedido
        return DB::table('pedidos')->where('user_id', $this->id)->where('deleted_at', null)->where('terminado', null)->first();
    }
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
