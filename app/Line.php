<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Line extends Model
	{
	    // cero a muchos con Pedido
	     public function order()
	    {
	       return $this->belongsTo('App\Order');
	    }

	    // cero a muchos con Libro
	     public function book()
	    {
		return $this->belongsTo('App\Book');
	    }

		public static function lineaborra($order_id){
			
			$lpedidos = Line::where('order_id', '=', $order_id);
			$lpedidos->delete();    
      }
	   public static function sacaarray($order_id){
 			$lineas = Line::where('order_id', '=', $order_id)->get();
	
		return $lineas;


    }
	}