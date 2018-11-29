<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comida;

class ComidaController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
           
            $comidas = Comida::join('categorias','comidas.idcategoria','=','categorias.id')
            ->select('comidas.id','comidas.idcategoria', 'comidas.nombre','categorias.nombre as nombre_categoria','comidas.precio_venta',
            'comidas.imagen','comidas.descripcion','comidas.condicion')     
            ->orderBy('comidas.id','desc')->paginate(4);


        }
        else{
            $comidas = Comida::join('categorias','comidas.idcategoria','=','categorias.id')
            ->select('comidas.id','comidas.idcategoria', 'comidas.nombre','categorias.nombre as nombre_categoria','comidas.precio_venta',
            'comidas.imagen','comidas.descripcion','comidas.condicion') 
            ->where('comidas.'.$criterio,'like','%'.$buscar . '%')     
            ->orderBy('comidas.id','desc')->paginate(4);

             
        }




        return [
            'pagination' => [
                'total'   =>$comidas->total(),
                'current_page'=>$comidas->currentPage(),
                'per_page'   =>$comidas->perPage(),
                'last_page'   =>$comidas->lastPage(),
                'from'   =>$comidas->firstItem(),
                'to'   =>$comidas->lastItem(),
            ],
            'comidas' =>$comidas
        ];
        
    }

    public function selectComida(Request $request)
    {
         if(!$request->ajax()) return redirect('/');
        $comidas = Comida::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return['comidas'=> $comidas];
    }



    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $comida =  new Comida();
        $comida->idcategoria = $request->idcategoria;
        $comida->nombre = $request->nombre;
        $comida->precio_venta = $request->precio_venta;
        $comida->imagen = $request->imagen;
        $comida->descripcion = $request->descripcion;
        $comida->condicion = '1';
        $comida->save();

    }

    
    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $comida =   Comida::findOrfail($request->id);
        $comida->idcategoria = $request->idcategoria;
        $comida->nombre = $request->nombre;
        $comida->precio_venta = $request->precio_venta;
        $comida->imagen = $request->imagen;
        $comida->descripcion = $request->descripcion;
        $comida->condicion = '1';
        $comida->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $comida =   Comida::findOrfail($request->id);
        $comida->condicion = '0';
        $comida->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $comida =   Comida::findOrfail($request->id);
        $comida->condicion = '1';
        $comida->save();
    }
}
