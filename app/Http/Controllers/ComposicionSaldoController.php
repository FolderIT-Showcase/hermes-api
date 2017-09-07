<?php

namespace App\Http\Controllers;

use App\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use JasperPHP\JasperPHP as JasperPHP;

class ComposicionSaldoController extends Controller
{
    public function imprimir(Request $request) {

        $cliente = $request->input('cliente', '0');
        $vendedor = $request->input('vendedor', '0');
        $zona = $request->input('zona', '0');

        $jasper = new JasperPHP;

        $output_path = base_path() . '/resources/assets/reports/tmp/composicionsaldo' . time();
        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $CLIENTE = '"' . $cliente . '"';
        $VENDEDOR = '"' . $vendedor . '"';
        $ZONA = '"' . $zona . '"';
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DIRECCION = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';

        $jasper->process(
            base_path() . '/resources/assets/reports/composicion_saldos.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "CLIENTE" => $CLIENTE,
                  "VENDEDOR" => $VENDEDOR,
                  "ZONA" => $ZONA,
                  "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                  "EMPRESA_DIRECCION" => $EMPRESA_DIRECCION,
                  "EMPRESA_CUIT" => $EMPRESA_CUIT,
                  "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return response()->download($output_path . '.pdf', 'Composición Saldo' . '.pdf')->deleteFileAfterSend(true);
    }
}
