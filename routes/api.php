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


Route::post("/login", 'Auth\LoginController@login');
Route::post("/register", 'Auth\RegisterController@register');

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::resource('clientes', 'ClienteController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('vendedores', 'VendedorController',
        ['only'       => ['index', 'store', 'show', 'update', 'destroy'],
         'parameters' => ['vendedores' => 'vendedor']]);

    Route::resource('rubros', 'RubroController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('subrubros', 'SubrubroController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('marcas', 'MarcaController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('articulos', 'ArticuloController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('provincias', 'ProvinciaController',
        ['only' => ['index', 'show']]);

    Route::resource('localidades', 'LocalidadController',
        ['only' => ['index', 'show'],
        'parameters' => ['localidades' => 'localidad']]);
});