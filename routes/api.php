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

Route::group(['middleware' => 'tenant.param'], function () {
    Route::post("/login", 'Auth\AuthController@login');
    Route::post("/password/forgot", 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post("/password/reset", 'Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post("/logout", 'Auth\AuthController@logout');
    Route::post("/refreshToken", 'Auth\AuthController@refresh');

    Route::get('clientes/codigo/{cod}', 'ClienteController@showByCode');
    Route::get('clientes/nombre/{nom}', 'ClienteController@showByName');
    Route::get('clientes/buscar/{busqueda}', 'ClienteController@showByAll');
    Route::get('clientes/reporte', 'ClienteController@report');
    Route::resource('clientes', 'ClienteController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('vendedores', 'VendedorController',
        ['only'       => ['index', 'store', 'show', 'update', 'destroy'],
         'parameters' => ['vendedores' => 'vendedor']]);

    Route::get('proveedores/cuentacorriente', 'CtaCteProveedorController@showByProvDate');
    Route::get('proveedores/cuentacorriente/reporte', 'CtaCteProveedorController@report');

    Route::get('proveedores/codigo/{cod}', 'ProveedorController@showByCode');
    Route::get('proveedores/nombre/{nom}', 'ProveedorController@showByName');
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
    Route::resource('tipocomprobantes', 'TipoComprobanteController',
        ['only' => ['index']]);

    Route::get('contadores/{punto_venta}/{tipo_comprobante_id}', 'ContadorController@showByPuntoVentaTipoComprobante');

    Route::get('comprobantes/presupuestos', 'ComprobanteController@indexPresupuestos');
    Route::get('comprobantes/presupuestos/mail/{comprobante_id}', 'ComprobanteController@enviarMailPresupuesto');
    Route::get('comprobantes/imprimir/{comprobante_id}', 'ComprobanteController@imprimir');
    Route::get('comprobantes/buscar', 'ComprobanteController@showByTypeDate');
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

    Route::get('periodosfiscales/filtrar', 'PeriodoFiscalController@showByAll');
    Route::get('periodosfiscales/abierto/{boo}', 'PeriodoFiscalController@showActive');
    Route::resource('periodosfiscales', 'PeriodoFiscalController',
        ['only' => ['index', 'show', 'store', 'update', 'destroy'],
            'parameters' => ['periodosfiscales' => 'periodofiscal']]);

    Route::get('reginfoventas/comprobantes', 'RegimenInformativoVentasController@reginfo_comprobantes');
    Route::get('reginfoventas/alicuotas', 'RegimenInformativoVentasController@reginfo_alicuotas');

    Route::resource('tiporetenciones', 'TipoRetencionController',
        ['only' => ['index', 'show', 'store', 'update', 'destroy'],
            'parameters' => ['tiporetenciones' => 'tiporetencion']]);

    Route::resource('tipocomprobantescompra', 'TipoComprobanteCompraController',
        ['only' => ['index']]);

    Route::get('comprobantescompra/tipocomp/{tipocomp}', 'ComprobanteCompraController@showByTipoComprobante');
    Route::get('comprobantescompra/proveedor/{prov}', 'ComprobanteCompraController@showByProveedor');
    Route::get('comprobantescompra/periodofiscal/{per}', 'ComprobanteCompraController@showByPeriodo');
    Route::get('comprobantescompra/filtrar', 'ComprobanteCompraController@showByAll');
    Route::resource('comprobantescompra', 'ComprobanteCompraController',
        ['only' => ['index', 'showByTipoComprobante', 'store', 'show', 'update', 'destroy'],
            'parameters' => ['comprobantescompra' => 'comprobantecompra']]);

    Route::get('libroiva', 'LibroIvaController@generarLibroIva');

    Route::get('resumenventas', 'ResumenVentasController@report');

    Route::resource('bancos', 'BancoController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::resource('cuentasbancarias', 'CuentaBancariaController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy'],
         'parameters' => ['cuentasbancarias' => 'cuentaBancaria']]);

    Route::resource('tipostarjeta', 'TipoTarjetaController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy'],
         'parameters' => ['tipostarjeta' => 'tipoTarjeta']]);

    Route::get('depositos/buscar', 'DepositoController@showByAll');
    Route::resource('depositos', 'DepositoController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::get('chequesterceros/buscar', 'ChequeTerceroController@showByAll');
    Route::resource('chequesterceros', 'ChequeTerceroController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy'],
         'parameters' => ['chequesterceros' => 'chequeTercero']]);

    Route::get('tarjetas/buscar', 'TarjetaController@showByAll');
    Route::resource('tarjetas', 'TarjetaController',
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    Route::get('cobros/comprobantes', 'CobroController@showComprobantes');
    Route::get('cobros/imprimir/{cobro_id}', 'CobroController@imprimir');
    Route::resource('cobros', 'CobroController',
        ['only' => ['store', 'show', 'update', 'destroy']]);

    Route::resource('mediospago', 'MedioPagoController',
        ['only' => ['index']]);

    Route::get('composicionsaldo/imprimir', 'ComposicionSaldoController@imprimir');

    Route::get('ordenespago/comprobantes', 'OrdenPagoController@showComprobantes');
});