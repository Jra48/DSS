<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Order;
use App\Line;
use App\Auth;

class OrderController extends BaseController
{
   public function index()
    {
        $pedidos = Order::paginate(5);
        return view('pedidosadmin', ['pedidos' => $pedidos]);
    }

    public function borra($id){
        
        $pedidos = Order::find($id);
        Line::lineaborra($id);
         $pedidos->delete();
        return back();
    
    }

public  function datosenvio(Request $request){
  $user_id = Auth::user()->id;
   $pedido = Order::where('user_id', '=', $user_id);
    dd($request->localidad);

}
 public  function pedidousuarioid($user_id, $order_id){

  //  $pedido = Order::where('user_id', '=', $user_id);
  // $pedido= Order::where('user_id',$user_id)->first();
  // $lineas = Line::where('order_id', '=', 1)->get();
  $lineas = Line::sacaarray($order_id);
  $total=0;
  foreach($lineas as $linea)
	{
        $total = $total + $linea->precio_libro;
       
	}
    
      
     $pedido= Order::orderporuser($user_id);
     
       $pedido -> fecha = $linea->updated_at;
    //$table->string('calle');
    //$table->string('localidad');
    $pedido -> precio_total = $total;
    $pedido -> precio_envio = 6;
    $pedido -> total = $total + 6;
      $pedido->save();
        
    return view('micarro')->with('pedido',$pedido);
   // dd($lineas);


    }

public function update(){
    


}


    public function indexasc()
    {
        $pedido = Order::orderby('fecha','asc')->paginate(5);
        return view('pedidosadmin', ['pedidos' => $pedido]);
    }

   
    


      

}
