<?php

namespace App\Http\Controllers;


use App\PeriodoFiscal;
use App\Parametro;
use JasperPHP\JasperPHP as JasperPHP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LibroIvaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_periodoFiscal', ['only' => ['show']]);
    }

    /**
     * Generate report
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @internal param $tipoLibroIva
     * @internal param $periodofiscal_id
     * @internal param $page_init
     */
    public function generarLibroIva(Request $request) {

        $page_init = $request->input('page_init', '0');
        $tipoLibroIva = $request->input('tipo_libro_iva', '');
        $periodo_mes = $request->input('periodo_month', '0');
        $periodo_anio = $request->input('periodo_year', '0');

        $periodofiscal = PeriodoFiscal::where('mes', $periodo_mes)
            ->where('anio', $periodo_anio)
            ->first();
        $periodofiscal_str = (substr('0' . $periodo_mes, -2, 2)) . '-' . $periodo_anio;
        $output_path = '';

        switch($tipoLibroIva){
            case 'compras':
                $output_path = $this->generarLibroIvaCompras($periodofiscal, $periodofiscal_str, $page_init);
                $filename = 'libro_iva_compras_' . $periodofiscal_str;
                break;
            case 'ventas':
                $output_path = $this->generarLibroIvaVentas($periodo_mes, $periodo_anio, $page_init);
                $filename = 'libro_iva_ventas_' . $periodofiscal_str;
                break;
        }

        return response()->download($output_path . '.pdf', $filename . '.pdf')->deleteFileAfterSend(true);
    }

    private function generarLibroIvaCompras($periodofiscal, $periodofiscal_str, $page_init){
        $jasper = new JasperPHP;

        $output_path = base_path() . '/resources/assets/reports/tmp/libroIvaCompras' . $periodofiscal_str .time();
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DIRECCION = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPORESPONSABLE = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $EMPRESA_TELEFONO = '455066';
        $INIT_PAGE = $page_init;
        $PERIODOFISCAL = $periodofiscal_str;
        $PERIODO_ID = $periodofiscal->id;

        $jasper->process(
            base_path() . '/resources/assets/reports/Libro_Iva_Compras.jasper',
            $output_path,
            array("pdf"),
            array(
                "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                "EMPRESA_DIRECCION" => $EMPRESA_DIRECCION,
                "EMPRESA_CUIT" => $EMPRESA_CUIT,
                "EMPRESA_TIPORESPONSABLE" => $EMPRESA_TIPORESPONSABLE,
                "EMPRESA_TELEFONO" => $EMPRESA_TELEFONO,
                "INIT_PAGE" => $INIT_PAGE,
                "PERIODOFISCAL" => $PERIODOFISCAL,
                "PERIODO_ID" => $PERIODO_ID
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return $output_path;
    }

    private function generarLibroIvaVentas($periodo_mes, $periodo_anio, $page_init) {
        $jasper = new JasperPHP;

        $periodofiscal_str = (substr('0' . $periodo_mes, -2, 2)) . '-' . $periodo_anio;
        $output_path = base_path() . '/resources/assets/reports/tmp/libroIvaVentas' . $periodofiscal_str .time();
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DIRECCION = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPORESPONSABLE = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $EMPRESA_TELEFONO = '455066';
        $INIT_PAGE = $page_init;
        $PERIODO_MES = $periodo_mes;
        $PERIODO_ANIO = $periodo_anio;

        $jasper->process(
            base_path() . '/resources/assets/reports/libro_iva_ventas.jasper',
            $output_path,
            array("pdf"),
            array(
                "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                "EMPRESA_DIRECCION" => $EMPRESA_DIRECCION,
                "EMPRESA_CUIT" => $EMPRESA_CUIT,
                "EMPRESA_TIPORESPONSABLE" => $EMPRESA_TIPORESPONSABLE,
                "EMPRESA_TELEFONO" => $EMPRESA_TELEFONO,
                "INIT_PAGE" => $INIT_PAGE,
                "PERIODO_MES" => $PERIODO_MES,
                "PERIODO_ANIO" => $PERIODO_ANIO
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return $output_path;
    }
}