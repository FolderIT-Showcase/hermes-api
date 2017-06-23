<?php

namespace App\Http\Controllers;

use App\CtaCteCliente;
use App\Parametro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use JasperPHP\JasperPHP as JasperPHP;

class CtaCteClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_cta_cte', ['only' => ['showByClientDate', 'report']]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param CtaCteCliente $ctaCteCliente
     */
    public function showByClientDate(Request $request)
    {
        $cliente_id = $request->input('cliente_id', '0');
        $fecha_inicio = $request->input('fecha_inicio', Carbon::create(1928, 1, 1, 0, 0, 0)->format('yyyy-MM-dd'));
        $fecha_fin = $request->input('fecha_fin', Carbon::today()->format('yyyy-MM-dd'));

        return response()->json(
            CtaCteCliente::where('cliente_id', $cliente_id)->whereBetween('fecha', [$fecha_inicio, $fecha_fin])->orderBy('fecha', 'ASC')->orderBy('updated_at', 'ASC')->with('tipo_comprobante')->with('comprobante')->get()
        );
    }

    /**
     * Generate report
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function report(Request $request)
    {
        $cliente_id = $request->input('cliente_id', '0');
        $fecha_inicio = $request->input('fecha_inicio', Carbon::create(1928, 1, 1, 0, 0, 0)->format('yyyy-MM-dd'));
        $fecha_fin = $request->input('fecha_fin', Carbon::today()->format('yyyy-MM-dd'));

        $fecha_inicio = str_replace("-", "/", $fecha_inicio);
        $fecha_fin = str_replace("-", "/", $fecha_fin);
        $jasper = new JasperPHP;
        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $CLIENTE_ID = '"' . $cliente_id . '"';
        $FECHA_INICIO = '"' . $fecha_inicio . '"';
        $FECHA_FIN = '"' . $fecha_fin . '"';

        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/cuenta_corriente_clientes' . time();

        $jasper->process(
            base_path() . '/resources/assets/reports/cuenta_corriente_clientes.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "CLIENTE_ID" => $CLIENTE_ID,
                  "FECHA_FIN" => $FECHA_FIN,
                  "FECHA_INICIO" => $FECHA_INICIO,
                  "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                  "EMPRESA_DIRECCION" => $EMPRESA_DOMICILIO,
                  "EMPRESA_CUIT" => $EMPRESA_CUIT,
                  "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP,
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return response()->download($output_path . '.pdf', 'cuenta_corriente.pdf')->deleteFileAfterSend(true);
    }
}
