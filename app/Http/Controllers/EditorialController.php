<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Editorial;

class EditorialController extends BaseController
{
   public function index()
    {
        $editoriales = Editorial::paginate(5);
        return view('editorialesadmin', ['editoriales' => $editoriales]);
    }

    public function borra($id){
        
        $editorial = Editorial::find($id);
        $editorial->delete();
        return back();
    
    }
    public function indexnameasc()
    {
        $editorial = Editorial::orderby('nombre','asc')->paginate(5);
        return view('editorialesadmin', ['editoriales' => $editorial]);
    }

    
     

 

    public function create(){
        return view('editorialesadmincreate');
    }

    public function store(Request $request){
        Editorial::create($request->all());
        return redirect('/editorialesadmin');
    }
    
    public function edit(Request $request,$id){

        $nuevoNombre= $request->input('nombre');
        $nuevoTelefono= $request->input('telefono');
        $nuevoDireccion= $request->input('direccion');

        $editorial = Editorial::find($id);
        $editorial->nombre=$nuevoNombre;
        $editorial->telefono=$nuevoTelefono;
        $editorial->direccion=$nuevoDireccion;
        $editorial->save();
    
        return redirect()->action('EditorialController@index');
    }
         

    public function preEdit($id){

        $editorial= Editorial::where('id',$id)->first();
        return view('editorialesadminedit')->with('editorial',$editorial);
    
    }

      

}
