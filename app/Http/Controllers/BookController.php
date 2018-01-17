<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Book;
use App\Editorial;
use Storage;

class BookController extends BaseController
{
    /* Buscar por tematica */
    public function index(Request $request)
    {
        $libros = Book::tematica($request->get('tematica'))->paginate(5);
        return view('librosadmin', ['libros' => $libros]);
    }

    /* Buscar por precio */
    public function indexprecio(Request $request){
        $libros = Book::precio($request->get('precio'))->paginate(5);
        return view('librosadmin', ['libros' => $libros]);
    }

    public function indexpriceasc()
    {
        $libros = Book::orderby('precio','asc')->paginate(5);
        return view('librosadmin', ['libros' => $libros]);
    }
      public function indexpricedesc()
    {
        $libros = Book::orderby('precio','desc')->paginate(5);
        return view('librosadmin', ['libros' => $libros]);
    }

    

    public function borra($id){
        
        $libro = Book::find($id);
        $libro->delete();
        return back();
    
    }

     public function create(){
        return view('booksadmincreate');
    }

    public function store(Request $request){

        //Book::create($request->all());
        $libro = new Book();
        $libro->titulo = $request->titulo;
        $libro->precio = $request->precio;
        $libro->tematica = $request->tematica;
        $libro->descripcion = $request->descripcion;
        $libro->cantidad = $request->cantidad;
        $libro->editorial_id = $request->editorial_id;
        
        $img = $request->file('urlImagen');
        $file_route = $img->getClientOriginalName();

        Storage::disk('imgBooks')->put($file_route, file_get_contents($img->getRealPath()));
        $libro->urlImagen = $file_route;

        $libro->save();
        return redirect('/librosadmin');

    }

    //editar un libro
    public function edit(Request $request,$id){
     
        $titulo= $request->input('titulo');
        $precio= $request->input('precio');
        $tematica= $request->input('tematica');
        $descripcion= $request->input('descripcion');
        $cantidad= $request->input('cantidad');
        $imagen = $request->input('urlImagen');
        $editorial_id= $request->input('editorial_id');


        $libro = Book::find($id);
        
        $libro->titulo=$titulo;
        $libro->precio=$precio;
        $libro->tematica=$tematica;
        $libro->descripcion=$descripcion;
        $libro->cantidad=$cantidad;
        $libro->urlImagen=$imagen;
        $libro->editorial_id=$editorial_id;
        $libro->save();

        return redirect()->action('BookController@index');
    }
         

    public function preEdit($id){
    
        $libro= Book::where('id',$id)->first();
        return view('librosadminedit')->with('libro',$libro);

    }


    public function consultar($id){
    
        $libro= Book::where('id',$id)->first();
        return view('consultalibro')->with('libro',$libro);

    }

    public function recomended(){
        $libros = Book::All();
        return view('librosrecomended', ['libros'=> $libros]);
    }

    public function getTematica(){
        $ficcion = Book::where('tematica', 'Ficcion')->get();
        $cocina = Book::where('tematica', 'Cocina')->get();
        $humor = Book::where('tematica', 'Humor')->get();
        $novela = Book::where('tematica', 'Novela')->get();
        $terror = Book::where('tematica', 'Terror')->get();
        return view('inicio', ['ficcion' => $ficcion, 
                            'cocina' => $cocina, 
                            'humor' => $humor,
                            'novela' => $novela,
                            'terror'=> $terror]);
    }

    //Todos los libros
    public function getAllBooks(){
        $libros = Book::All();
        return view('todosloslibros', ['libros'=> $libros]);
    }

    //1. Libros de Ficcion
    public function getBooksFiccion(){
        $libros = Book::where('tematica', 'Ficcion')->paginate(4);
        return view('librosficcion', ['libros' => $libros]);
    }
    //2. Libros de cocina
    public function getBooksCocina(){
        $libros = Book::where('tematica', 'Cocina')->paginate(4);
        return view('libroscocina', ['libros' => $libros]);
    }

    //3. Libros de terror
    public function getBooksTerror(){
        $libros = Book::where('tematica', 'Terror')->paginate(4);
        return view('librosterror', ['libros' => $libros]);
    }

    //4. Libros de humor
    public function getBooksHumor(){
        $libros = Book::where('tematica', 'Humor')->paginate(4);
        return view('libroshumor', ['libros' => $libros]);
    }

    //5. Novelas
    public function getBooksNovela(){
        $libros = Book::where('tematica', 'Novela')->paginate(4);
        return view('librosnovela', ['libros' => $libros]);
    }


    public function search(Request $request)
    {
        //dd($request->dato);
        $libros = Book::where('tematica','=' ,$request->dato)->get();
        $je = count($libros);
        if ($je != 0){
   return view('librosrecomended', ['libros'=> $libros]);
        }
        else{
            $libros = Book::where('titulo','=' ,$request->dato)->get();
            $je2 = count($libros);
            if ($je2 != 0){
                return view('librosrecomended', ['libros'=> $libros]);
            }
            else{
              $edito= Editorial::buscaid($request->dato);
              $libros = Book::where('editorial_id','=' ,$edito)->get();
              $s = count($libros);
              if($s !=0){
                   return view('librosrecomended', ['libros'=> $libros]);

              }
              else{
                 return redirect('/');

              }
              
               
              
            }
        }
        
       // $autores = Author::name($request->get('nombre'))->paginate(5);
       // return view('autoresadmin', ['autores' => $autores]);
    }
}

