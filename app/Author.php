<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Author extends Model
{
    public $timestamps = false;
    protected $fillable = ['nombre', 'apellidos', 'fechanacimiento'];
    
    //muchos a muchos con libro
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    public function scopeName($query, $nombre){
        if($nombre != "")
        {
            $query->where("nombre", "LIKE", "%$nombre%");
        }
    }
}
