<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use PhpParser\Comment\Doc;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndPermissions;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable= ['nombre','email','apellido','documento','password'];


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
        return $this->belongsTo(Documento::class);
    }    
    public function direccions()
    {
        return $this->belongsToMany(Direccion::class);
    }    
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }   
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }      
}
