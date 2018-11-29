<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
           
            $pedidos = Pedido::join('comidas','pedidos.idcomida','=','comidas.id')
            ->select('pedidos.id','pedidos.idcomida','pedidos.codigo','comidas.nombre as nombre_comida','pedidos.cantidad_platos',
            'comidas.precio_venta', 'pedidos.numero_mesa','pedidos.fecha_hora','pedidos.condicion')     
            ->orderBy('pedidos.id','desc')->paginate(4);


        }
        else{
            $pedidos = Pedido::join('comidas','pedidos.idcomida','=','comidas.id')
            ->select('pedidos.id','pedidos.idcomida','pedidos.codigo','comidas.nombre as nombre_comida','pedidos.cantidad_platos',
            'comidas.precio_venta','pedidos.numero_mesa','pedidos.fecha_hora','pedidos.condicion')       
            ->where('pedidos.'.$criterio,'like','%'.$buscar . '%')     
            ->orderBy('pedidos.id','desc')->paginate(4);

             
        }




        return [
            'pagination' => [
                'total'   =>$pedidos->total(),
                'current_page'=>$pedidos->currentPage(),
                'per_page'   =>$pedidos->perPage(),
                'last_page'   =>$pedidos->lastPage(),
                'from'   =>$pedidos->firstItem(),
                'to'   =>$pedidos->lastItem(),
            ],
            'pedidos' =>$pedidos
        ];
        
    }

 
    public function buscarPedidoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $pedidos = Pedido::Where('codigo','=', $filtro)
        ->select('id','cantidad_platos','numero_mesa')
        ->orderBy('numero_mesa', 'asc')
        ->take(1)->get();

        return ['pedidos' => $pedidos];
    }

    public function listarPedidoVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $pedidos = Pedido::join('comidas','pedidos.idcomida','=','comidas.id')
            ->select('pedidos.id','pedidos.idcomida','pedidos.codigo','comidas.nombre as nombre_comida','pedidos.cantidad_platos',
            'comidas.precio_venta', 'pedidos.numero_mesa','pedidos.fecha_hora','pedidos.condicion')     
            ->where('pedidos.condicion','=','1')
            ->orderBy('pedidos.id','desc')->paginate(6);
        }
        else{
            $pedidos = Pedido::join('comidas','pedidos.idcomida','=','comidas.id')
            ->select('pedidos.id','pedidos.idcomida','pedidos.codigo','comidas.nombre as nombre_comida','pedidos.cantidad_platos',
            'comidas.precio_venta', 'pedidos.numero_mesa','pedidos.fecha_hora','pedidos.condicion') 
            ->where('pedidos.'.$criterio,'like','%'.$buscar . '%')     
            ->where('pedidos.condicion','=','1')
            ->orderBy('pedidos.id', 'desc')->paginate(6);
        }
        

        return ['pedidos' => $pedidos];
    }
    public function listarPdf(){
        $pedidos = Pedido::join('comidas','pedidos.idcomida','=','comidas.id')
        ->select('pedidos.id','pedidos.idcomida','pedidos.codigo','comidas.nombre as nombre_comida','pedidos.cantidad_platos',
        'comidas.precio_venta', 'pedidos.numero_mesa','pedidos.fecha_hora','pedidos.condicion')     
        ->orderBy('pedidos.id','desc')->get();
        $cont=Pedido::count();
        $pdf =\PDF::loadView('pdf.pedidospdf',['pedidos'=>$pedidos,'cont'=>$cont]);
        return $pdf->download('pedidos.pdf');
        
    }



    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $myTime = Carbon::now('America/Lima');
        $pedido =  new Pedido();
        $pedido->idcomida = $request->idcomida;
        $pedido->codigo = $request->codigo;
        $pedido->numero_mesa = $request->numero_mesa;
        $pedido->cantidad_platos = $request->cantidad_platos ;
         $pedido->fecha_hora = $myTime->toDateString();
        $pedido->condicion = '1';
        $pedido->save();

    }

    
    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $pedido =   Pedido::findOrfail($request->id);
        $pedido->idcomida = $request->idcomida;
        $pedido->codigo = $request->codigo;
        $pedido->numero_mesa = $request->numero_mesa;
        $pedido->cantidad_platos = $request->cantidad_platos ;       
        $pedido->fecha_hora = $myTime->toDateString();
        $pedido->condicion = '1';
        $pedido->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $pedido =   Pedido::findOrfail($request->id);
        $pedido->condicion = '0';
        $pedido->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $pedido =   Pedido::findOrfail($request->id);
        $pedido->condicion = '1';
        $pedido->save();
    }
}

