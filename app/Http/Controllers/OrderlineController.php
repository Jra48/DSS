<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Line;
use App\Book;
use App\Order;
use Exception;


class OrderlineController extends BaseController
{
   public function index()
    {
        $lpedidos = Line::paginate(5);
        return view('lineaspedidosadmin', ['lpedidos' => $lpedidos]);
    }

    public function borra($id){
        
        $lpedidos = Line::find($id);
        $lpedidos->delete();
        return back();
    }

      public function lineaborra($order_id){
        
        $lpedidos = Line::find($order_id);
        $lpedidos->delete();    
      }


    public function indexnameasc()
    {
        $pedido = Line::orderby('nombre','asc')->paginate(5);
        return view('pedidosadmin', ['pedidos' => $pedido]);
    }
/*
    public function getIdUsuario($id) {
return $id;
}*/

  public function add($id, $idusuario)
    {
        $libroprecio = Book::buscaprecio($id);
        $idusuariO =  $idusuario;  // paso id usuario de la sesion para bsucar su PEDIDO.
        $pedidoid = Order::buscaid($idusuariO);
        $nombrelibro = Book::buscanombre($id);

        $lpedido = new Line();
        $lpedido->precio_libro = $libroprecio;
        $lpedido->numUnidades = 1;
        $lpedido->book_id =$id;
        $lpedido->nombre = $nombrelibro;
        $lpedido->order_id = $pedidoid;

      $lpedido->save();
      return back();

       
    }


     public function muestra($id)
    {
         $pedidoid = Order::buscaid($id); //sacamos id pedido al que pertenece
          // $lineas= Order::where('id',$pedidoid)->all(); // sacamos lineas de ese pedido
    
          $lineas = Line::where('order_id', '=', $pedidoid)->get();
          $je = count($lineas);
          if($je == 0)
          return redirect('/home');
        else
        return view('lineas', ['lineas'=> $lineas]);

    
    }
   
    

   
    


      

}
