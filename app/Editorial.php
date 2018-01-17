<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $fillable = ['nombre', 'telefono', 'direccion'];

     public function books()
    {
        return $this->hasMany('App\Book');
    }

     public static function buscaid($x){	
		$edito= Editorial::where('nombre',$x)->first();
        $compurba = count($edito);
        if($compurba == 0){ 
            $id = 10000;
        }
        else{
        $id = $edito->id;
       
        }
        
	     return $id;

      }
      
}
