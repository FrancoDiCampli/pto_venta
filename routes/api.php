<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user' => 'API\UserController'
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

Route::get('inventario/{id}','API\InventariosController@traerInventario')->name('inventario.traer');

Route::get('findCliente','API\ClientesController@searchUser');
Route::get('findCategoria','API\CategoriasController@searchCategory');
Route::get('findArticulo','API\ArticulosController@searchArticle');

