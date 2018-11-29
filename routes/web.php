<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['guest']],function(){
  Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

});
Route::group(['middleware'=>['auth']],function(){
         Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('/main', function () {
            return view('/contenido/contenido');
        })->name('main');      

        Route::group(['middleware'=>['Cajero']],function(){

            Route::get('/categoria','CategoriaController@index'); 
            Route::post('/categoria/registrar','CategoriaController@store'); 
            Route::put('/categoria/actualizar','CategoriaController@update'); 
            Route::put('/categoria/desactivar','CategoriaController@desactivar'); 
            Route::put('/categoria/activar','CategoriaController@activar'); 
            Route::get('/categoria/selectCategoria','CategoriaController@selectCategoria'); 
    
    
            Route::get('/comida','ComidaController@index'); 
            Route::post('/comida/registrar','ComidaController@store'); 
            Route::put('/comida/actualizar','ComidaController@update'); 
            Route::put('/comida/desactivar','ComidaController@desactivar'); 
            Route::put('/comida/activar','ComidaController@activar'); 
            Route::get('/comida/selectComida','ComidaController@selectComida'); 

            Route::get('/pedido','PedidoController@index'); 
            Route::post('/pedido/registrar','PedidoController@store'); 
            Route::put('/pedido/actualizar','PedidoController@update'); 
            Route::put('/pedido/desactivar','PedidoController@desactivar'); 
            Route::put('/pedido/activar','PedidoController@activar'); 
            Route::get('/pedido/buscarPedidoVenta', 'PedidoController@buscarPedidoVenta');
            Route::get('/pedido/listarPedidoVenta', 'PedidoController@listarPedidoVenta');
            Route::get('/pedido/listarPdf', 'PedidoController@listarPdf')->name('pedidos_pdf');

            Route::get('/cliente','ClienteController@index'); 
            Route::post('/cliente/registrar','ClienteController@store'); 
            Route::put('/cliente/actualizar','ClienteController@update');
            Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

            Route::get('/venta', 'VentaController@index');
            Route::post('/venta/registrar', 'VentaController@store');
            Route::put('/venta/desactivar', 'VentaController@desactivar');
            Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
            Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
            Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');

        });  
        Route::group(['middleware'=>['Administrador']],function(){

                Route::get('/categoria','CategoriaController@index'); 
                Route::post('/categoria/registrar','CategoriaController@store'); 
                Route::put('/categoria/actualizar','CategoriaController@update'); 
                Route::put('/categoria/desactivar','CategoriaController@desactivar'); 
                Route::put('/categoria/activar','CategoriaController@activar'); 
                Route::get('/categoria/selectCategoria','CategoriaController@selectCategoria'); 


                Route::get('/comida','ComidaController@index'); 
                Route::post('/comida/registrar','ComidaController@store'); 
                Route::put('/comida/actualizar','ComidaController@update'); 
                Route::put('/comida/desactivar','ComidaController@desactivar'); 
                Route::put('/comida/activar','ComidaController@activar'); 
                Route::get('/comida/selectComida','ComidaController@selectComida'); 

                Route::get('/pedido','PedidoController@index'); 
                Route::post('/pedido/registrar','PedidoController@store'); 
                Route::put('/pedido/actualizar','PedidoController@update'); 
                Route::put('/pedido/desactivar','PedidoController@desactivar'); 
                Route::put('/pedido/activar','PedidoController@activar'); 
                Route::get('/pedido/buscarPedidoVenta', 'PedidoController@buscarPedidoVenta');
                Route::get('/pedido/listarPedidoVenta', 'PedidoController@listarPedidoVenta');
                Route::get('/pedido/listarPdf', 'PedidoController@listarPdf')->name('pedidos_pdf');


                Route::get('/cliente','ClienteController@index'); 
                Route::post('/cliente/registrar','ClienteController@store'); 
                Route::put('/cliente/actualizar','ClienteController@update');
                Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

                Route::get('/rol','RolController@index');
                Route::get('/rol/selectRol','RolController@selectRol'); 
                            
                Route::get('/user','UserController@index'); 
                Route::post('/user/registrar','UserController@store'); 
                Route::put('/user/actualizar','UserController@update'); 
                Route::put('/user/desactivar','UserController@desactivar'); 
                Route::put('/user/activar','UserController@activar');

                Route::get('/venta', 'VentaController@index');
                Route::post('/venta/registrar', 'VentaController@store');
                Route::put('/venta/desactivar', 'VentaController@desactivar');
                Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
                Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
                Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');

      });    
      
      Route::group(['middleware'=>['Cliente']],function(){

            Route::get('/pedido','PedidoController@index'); 
            Route::post('/pedido/registrar','PedidoController@store'); 
            Route::put('/pedido/actualizar','PedidoController@update'); 
            Route::put('/pedido/desactivar','PedidoController@desactivar'); 
            Route::put('/pedido/activar','PedidoController@activar'); 
     
    }); 

  });

//Route::get('/home', 'HomeController@index')->name('home');
