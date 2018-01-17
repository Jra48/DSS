<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

     
    protected $fillable = ['titulo', 'precio', 'tematica', 'descripcion', 'cantidad', 'urlImagen','editorial_id'];
    
    //Book tiene la clave ajena 'editorial_id'
    public function editorial()
    {
        return $this->belongsTo('App\Editorial');
    }

    //Muchos a muchos con author
    public function authors()
    {
        return $this->belongsToMany('App\Author');
    }
    
    
    // muchos a muchos con linea pedido
   
    public function lines()
    {
        return $this->hasMany('App\Line');
    }

    public function scopeTematica($query, $tematica){
        if($tematica != "")
        {
            $query->where("tematica", "LIKE", "%$tematica%");
        }
    }

    public function scopePrecio($query, $precio){
        if($precio != "")
        {
            $query->where("precio", "<=", $precio);
        }
    }

    public static function buscaprecio($id){
			
		$precio= Book::where('id',$id)->first();
        $price= $precio -> precio;
	    return $price; 
      }

    public static function buscanombre($id){
			
		$nombre= Book::where('id',$id)->first();
        $name= $nombre -> titulo;
	    return $name; 
      }

}
