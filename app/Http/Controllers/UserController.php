<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;

class UserController extends BaseController
{
    public function index()
    {
        $usuarios = User::paginate(5);
        return view('usuariosadmin', ['usuarios' => $usuarios]);
    }

public function indexnameasc()
    {
        $usuarios = User::orderby('nombre','asc')->paginate(5);
        return view('usuariosadmin', ['usuarios' => $usuarios]);
    }

    
     
    public function borra($id){
        
        $user = User::find($id);
        $user->delete();
        return back();
    
    }

    public function create(){
        return view('usuariosadmincreate');
    }

    public function store(Request $request){
        User::create($request->all());
        return redirect('/usuariosadmin');

    }

    public function edit(Request $request,$id){
     
      $nuevoNombre= $request->input('nombre');
      $nuevoApellidos= $request->input('apellidos');
      $nuevoCuenta= $request->input('ncuenta');
      $nuevoUsuario= $request->input('usuario');
      $nuevoContra= $request->input('contrasena');

      $usuario = User::find($id);
      $usuario->nombre=$nuevoNombre;
      $usuario->apellidos=$nuevoApellidos;
      $usuario->ncuenta=$nuevoCuenta;
      $usuario->usuario=$nuevoUsuario;
        $usuario->contrasena=$nuevoContra;
        $usuario->save();
                 return redirect()->action('UserController@index');
        }
         

     public function preEdit($id){
    
       $usuario= User::where('id',$id)->first();
       return view('usuariosadminedit')->with('usuario',$usuario);
       }

}