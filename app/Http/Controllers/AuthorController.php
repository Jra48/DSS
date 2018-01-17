<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Author;

class AuthorController extends BaseController
{
    public function index(Request $request)
    {

        $autores = Author::name($request->get('nombre'))->paginate(5);
        return view('autoresadmin', ['autores' => $autores]);
    }

    public function indexnameasc()
    {
        $autores = Author::orderby('nombre','asc')->paginate(5);
        return view('autoresadmin', ['autores' => $autores]);
    }

    
       
    public function borra($id){
        
        $author = Author::find($id);
        $author->delete();
        return back();
    
    }

    public function create(){
        return view('autoresadmincreate');
    }

    public function store(Request $request){
        Author::create($request->all());
        return redirect('/autoresadmin');
    }

    public function edit(Request $request, $id){
     
        $nuevoNombre= $request->input('nombre');
        $nuevoApellido= $request->input('apellidos');
        $nuevaFecha= $request->input('fechanacimiento');

        $autor = Author::find($id);
        $autor->nombre = $nuevoNombre;
        $autor->apellidos = $nuevoApellido;
        $autor->fechanacimiento = $nuevaFecha;
        $autor->save();
        
        return redirect()->action('AuthorController@index');
    }
         

     public function preEdit($id){
    
       $autor = Author::where('id', $id)->first();
       return view('autoresadminedit')->with('autor', $autor);
    }
}