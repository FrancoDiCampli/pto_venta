<?php

use Illuminate\Http\Request;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user' => 'API\UserController'
]);

Route::apiResources([
    'suppliers' => 'API\SuppliersController'
]);

Route::apiResources([
    'marcas' => 'API\MarcasController'
]);

Route::apiResources([
    'clientes' => 'API\ClientesController'
]);

Route::apiResources([
    'categorias' => 'API\CategoriasController'
]);

Route::apiResources([
    'articulos' => 'API\ArticulosController'
]);

Route::apiResources([
    'inventarios' => 'API\InventariosController'
]);

Route::apiResources([
    'facturas' => 'API\FacturasController'
]);

Route::apiResources([
    'remitos' => 'API\RemitosController'
]);

Route::get('inventario/{id}', 'API\InventariosController@traerInventario')->name('inventario.traer');

Route::post('/moverinventario/{id}', 'API\InventariosController@moverInventario')->name('inventario.mover');


Route::get('findCliente', 'API\ClientesController@searchUser');
Route::get('findCategoria', 'API\CategoriasController@searchCategory');
Route::get('findArticulo', 'API\ArticulosController@searchArticle');
Route::get('findSupplier', 'API\SuppliersController@searchSupplier');
Route::get('findMarca', 'API\MarcasController@searchMarca');

Route::get('/buscarCliente/{buscar}', 'API\ClientesController@buscar');

Route::get('/codArticulo/{codigo}', 'API\ArticulosController@buscarCodigo');
Route::get('/nomArticulo/{articulo}', 'API\ArticulosController@buscarArticulo');
Route::get('/traerInventario/{articulo}', 'API\ArticulosController@traerInventario');

Route::get('/proveedores/{buscar}', 'API\SuppliersController@buscar');



Route::get('/facturar/{numfactura}', 'API\FacturasController@facturar');

Route::get('/lista', 'API\FacturasController@lista');

Route::get('/detalles/{factura}', 'API\FacturasController@detalles');

Route::get('/afip/{factura}', 'API\FacturasController@afip');

Route::get('/remitos/{i}/{f}', 'API\RemitosController@remitosFecha');
Route::get('/remitosProducto/{producto}', 'API\RemitosController@remitosProducto');

Route::get('/cliente/{cuit}', 'API\ClientesController@traerCliente');

Route::get('/factura/{id}', 'API\FacturasController@traerFactura');
