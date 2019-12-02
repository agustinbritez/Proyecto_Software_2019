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
        return $this->belongsTo(Documento::class, 'documento_id');
    }
    public function direcciones()
    {
        return $this->belongsToMany(Direccion::class, 'direccion_envios', 'user_id', 'direccion_id');
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'user_id')->orderBy('created_at', 'desc');
    }
    //obtiene el pedido que no se ha enviado
    public function pedidoAPagar()
    {
        // si el atributo pago_id es null significa que no pago
        //si es 1 finalizo el pedido
        return Pedido::where('user_id', $this->id)->where('deleted_at', null)->where('pago_id', null)->first();
    }
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function direccionPredeterminada()
    {
        # code...
        foreach ($this->direccionEnvios as $key => $direcEnv) {
            # code...
            if ($direcEnv->predeterminado) {
                return $direcEnv->direccion;
            }
        }
        return null;
    }
    public function direccionEnvios()
    {
        # code...
        return $this->hasMany(DireccionEnvio::class, 'user_id');
    }
    public function getDocumento()
    {
        if (is_null($this->documento) || is_null($this->numeroDocumento)) {
            return 'Sin Registrar';
        }
        return $this->documento->nombre . ': ' . $this->numeroDocumento;
    }
}
