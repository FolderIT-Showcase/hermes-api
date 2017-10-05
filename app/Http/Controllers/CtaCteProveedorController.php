<?php

namespace App\Http\Controllers;

use App\CtaCteProveedor;
use App\Parametro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use JasperPHP\JasperPHP as JasperPHP;

class CtaCteProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_cta_cte', ['only' => ['showByProvDate, report']]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param CtaCteProveedor $ctaCteProveedor
     */
    public function showByProvDate(Request $request)
    {
        $proveedor_id = $request->input('proveedor_id', '0');
        $fecha_inicio = $request->input('fecha_inicio', '0');
        $fecha_fin = $request->input('fecha_fin', '0');

        $compr = CtaCteProveedor::where('proveedor_id', $proveedor_id)
            ->orderBy('fecha', 'ASC')
            ->orderBy('updated_at', 'ASC')
            ->with('tipo_comp_compras')
            ->with('comprobante_compras')
            ->with('orden_pago');

        if($fecha_inicio != '0' && $fecha_fin != '0'){
            $compr = $compr->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        }

        return response()->json($compr->get());
    }

    /**
     * Generate report
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function report(Request $request)
    {
        $proveedor_id = $request->input('proveedor_id', '0');
        $fecha_inicio = $request->input('fecha_inicio', '0');
        $fecha_fin = $request->input('fecha_fin', '0');

        if($fecha_inicio == '0'){
            $fecha_inicio = Carbon::create(1928, 1, 1, 0, 0, 0)->toDateString();
        }
        if($fecha_fin == '0'){
            $fecha_fin = Carbon::today()->toDateString();
        }

        $fecha_inicio = str_replace("-", "/", $fecha_inicio);
        $fecha_fin = str_replace("-", "/", $fecha_fin);

        $jasper = new JasperPHP;
        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $PROVEEDOR_ID = '"' . $proveedor_id . '"';
        $FECHA_INICIO = '"' . $fecha_inicio . '"';
        $FECHA_FIN = '"' . $fecha_fin . '"';

        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/cuenta_corriente_proveedores' . time();

        $jasper->process(
            base_path() . '/resources/assets/reports/cuenta_corriente_proveedores.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                "PROVEEDOR_ID" => $PROVEEDOR_ID,
                "FECHA_FIN" => $FECHA_FIN,
                "FECHA_INICIO" => $FECHA_INICIO,
                "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                "EMPRESA_DIRECCION" => $EMPRESA_DOMICILIO,
                "EMPRESA_CUIT" => $EMPRESA_CUIT,
                "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP,
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return response()->download($output_path . '.pdf', 'cuenta_corriente_proveedores.pdf')->deleteFileAfterSend(true);
    }
}