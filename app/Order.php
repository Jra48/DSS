<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Order extends Model
	{
	    //Clave Ajena Pedido Con Usuario
	    public function user()
	    {
		return $this->belongsTo('App\User');
	    }
	    
	    // uno a uno con Linea Pedido
	    public function lines()
	    {
		return $this->hasMany('App\Line');
	    }
	
		 public static function buscaid($id){	
		$x= Order::where('user_id',$id)->first();
        $ide= $x -> id;
	    return $ide; 

      }

		 public static function orderporuser($id){	
		$x= Order::where('user_id',$id)->first();
        
	    return $x; 

      }


			
		
	}