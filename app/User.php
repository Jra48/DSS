<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
 protected $fillable = ['nombre', 'apellidos', 'ncuenta', 'usuario','email','password'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
  

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



	    // Uno a uno de Usuario con Pedido
	    public function orders()
	    {
		return $this->hasMany('App\Order');
	    }
}
