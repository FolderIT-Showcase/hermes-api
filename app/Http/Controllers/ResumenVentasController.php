<?php

namespace App\Http\Controllers;

use App\Parametro;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use JasperPHP\JasperPHP as JasperPHP;

class ResumenVentasController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Generate report
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @internal param $vendedor
     * @internal param $zona
     * @internal param $provincia
     * @internal param $localidad
     * @internal param $activos
     */
    public function report(Request $request)
    {
        $tipoReporte = $request->input('tipo', '');
        $fechaInicio = $request->input('fecha_inicio', '0');
        $fechaFin = $request->input('fecha_fin', '0');
        $csvcodigos = $request->input('codigos', '');
        $arraycodigos = explode(',', $csvcodigos);
        $codigos = '(';
        foreach ($arraycodigos as $cod) {
            $codigos .= "'" . $cod . "',";
        }
        $codigos .= "'')";

        $filename = '';

        switch ($tipoReporte) {
            case 'fecha':
                $filename = 'detalle_diario_comprobantes_fecha_tipo';
                break;
            case 'tipo':
                $filename = 'detalle_diario_comprobantes_tipo';
                break;
            case 'resumen':
                $filename = 'resumen_comprobantes';
                break;
            case 'jurisdiccion':
                $filename = 'ventas_jurisdiccion';
                break;
        }

        $output_path = base_path() . '/resources/assets/reports/tmp/' . $filename . time();
        $input_file = base_path() . '/resources/assets/reports/' . $filename . '.jasper';

        $jasper = new JasperPHP;

        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DIRECCION = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_TELEFONO = '"' . Parametro::where('nombre', 'EMPRESA_TELEFONO')->first()->valor . '"';
        $FECHA_INICIO = '"' . $fechaInicio . '"';
        $FECHA_FIN = '"' . $fechaFin . '"';
        $CODIGOS = '"' . $codigos . '"';

        $jasper->process(
            $input_file,
            $output_path,
            array("pdf"),
            array(
                "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                "EMPRESA_DIRECCION" => $EMPRESA_DIRECCION,
                "EMPRESA_TELEFONO" => $EMPRESA_TELEFONO,
                "FECHA_INICIO" => $FECHA_INICIO,
                "FECHA_FIN" => $FECHA_FIN,
                "CODIGOS" => $CODIGOS,
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return response()->download($output_path . '.pdf', $filename . '.pdf')->deleteFileAfterSend(true);

    }
}
