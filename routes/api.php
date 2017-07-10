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

    Route::get('clientes/codigo/{cod}', 'ClienteController@showByCode');
    Route::get('clientes/nombre/{nom}', 'ClienteController@showByName');
    Route::get('clientes/buscar/{busqueda}', 'ClienteController@showByAll');
    Route::get('clientes/reporte', 'ClienteController@report');
    Route::resource('clientes', 'ClienteController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('vendedores', 'VendedorController',
        ['only'       => ['index', 'store', 'show', 'update', 'destroy'],
         'parameters' => ['vendedores' => 'vendedor']]);

    Route::get('proveedores/codigo/{cod}', 'ProveedorController@showByCode');
    Route::resource('proveedores', 'ProveedorController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy'],
            'parameters' => ['proveedores' => 'proveedor']]);

    Route::get('rubros/codigo/{cod}', 'RubroController@showByCode');
    Route::resource('rubros', 'RubroController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::get('subrubros/codigo/{cod}', 'SubrubroController@showByCode');
    Route::resource('subrubros', 'SubrubroController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::get('marcas/codigo/{cod}', 'MarcaController@showByCode');
    Route::resource('marcas', 'MarcaController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::get('articulos/codigo/{cod}', 'ArticuloController@showByCode');
    Route::get('articulos/nombre/{nom}', 'ArticuloController@showByName');
    Route::get('articulos/buscar', 'ArticuloController@showByAll');
    Route::resource('articulos', 'ArticuloController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('provincias', 'ProvinciaController',
        ['only' => ['index', 'show']]);

    Route::resource('localidades', 'LocalidadController',
        ['only' => ['index', 'show'],
        'parameters' => ['localidades' => 'localidad']]);

    Route::resource('zonas', 'ZonaController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::get('tipocomprobantes/{tipo_comprobante}/{cod}', 'TipoComprobanteController@showByTipoResponsable');

    Route::get('contadores/{punto_venta}/{tipo_comprobante_id}', 'ContadorController@showByPuntoVentaTipoComprobante');

    Route::get('comprobantes/presupuestos', 'ComprobanteController@indexPresupuestos');
    Route::get('comprobantes/presupuestos/imprimir/{comprobante_id}', 'ComprobanteController@imprimirPresupuesto');
    Route::get('comprobantes/presupuestos/mail/{comprobante_id}', 'ComprobanteController@enviarMailPresupuesto');
    Route::resource('comprobantes', 'ComprobanteController',
        ['only' => ['store', 'show', 'update', 'destroy']]);

    Route::post('listaprecios/importar', 'ListaPreciosController@import');
    Route::resource('listaprecios', 'ListaPreciosController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('parametros', 'ParametroController',
        ['only' => ['index']]);

    Route::resource('tipocategoriaclientes', 'TipoCategoriaClienteController',
        ['only' => ['index']]);

    Route::get('cuentacorriente/buscar', 'CtaCteClienteController@showByClientDate');
    Route::get('cuentacorriente/reporte', 'CtaCteClienteController@report');

    Route::get('roles', 'UserController@indexRoles');
    Route::resource('usuarios', 'UserController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('periodosfiscales', 'PeriodoFiscalController',
        ['only' => ['index', 'show', 'store', 'update', 'destroy'],
            'parameters' => ['periodosfiscales' => 'periodofiscal']]);
});