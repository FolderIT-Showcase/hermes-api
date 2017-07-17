<?php

namespace App\Http\Controllers;

use App\Comprobante;
use File;
use Illuminate\Http\Request;

class RegimenInformativoVentasController extends Controller
{
    public function reginfo_comprobantes(Request $request)
    {
        $month = $request->input('mes');
        $year = $request->input('año');

        $comprobantes = Comprobante::whereYear('fecha', '=', $year)
                            ->whereMonth('fecha', '=', $month)
                            ->get();

        $stringResultado = '';
        foreach ($comprobantes as $comprobante){
            $stringResultado .= $this->reginfo_comprobante($comprobante) . "\r\n";
        }
        $path =  base_path() . '/storage/app/tmp/REGINFO_CV_VENTAS_CBTE' . $month . $year . time() .'.txt';
        File::put($path, $stringResultado);

        return response()->download($path, 'REGINFO_CV_VENTAS_CBTE' . $month . $year . '.txt')->deleteFileAfterSend(true);
    }

    public function reginfo_alicuotas(Request $request)
    {
        $month = $request->input('mes');
        $year = $request->input('año');

        $comprobantes = Comprobante::whereYear('fecha', '=', $year)
            ->whereMonth('fecha', '=', $month)
            ->get();

        $stringResultado = '';
        foreach ($comprobantes as $comprobante){
            $stringResultado .= $this->reginfo_alicuota($comprobante) . "\r\n";
        }
        $path =  base_path() . '/storage/app/tmp/REGINFO_CV_VENTAS_ALICUOTAS' . $month . $year . time() .'.txt';
        File::put($path, $stringResultado);

        return response()->download($path, 'REGINFO_CV_VENTAS_ALICUOTAS' . $month . $year . '.txt')->deleteFileAfterSend(true);
    }

    protected function reginfo_comprobante($comprobante)
    {
        $resultado = '';

        //Fecha de comprobante
        $resultado .= str_replace('-', '', $comprobante->fecha);

        //Tipo de comprobante
        switch ($comprobante->tipo_comprobante->codigo) {
            case 'FCA':
                $resultado .= '001';
                break;
            case 'FCB':
                $resultado .= '006';
                break;
            case 'FCC':
                $resultado .= '011';
                break;
            case 'NDA':
                $resultado .= '002';
                break;
            case 'NDB':
                $resultado .= '007';
                break;
            case 'NDC':
                $resultado .= '012';
                break;
            case 'NCA':
                $resultado .= '003';
                break;
            case 'NCB':
                $resultado .= '008';
                break;
            case 'NCC':
                $resultado .= '014';
                break;
        }

        //Punto de venta
        $resultado .= str_pad(strval($comprobante->punto_venta), 5, '0', STR_PAD_LEFT);

        //Número de comprobante
        $resultado .= str_pad(strval($comprobante->numero), 20, '0', STR_PAD_LEFT);

        //Número de comprobante hasta
        $resultado .= str_pad(strval($comprobante->numero), 20, '0', STR_PAD_LEFT);

        //Código de documento del comprador
        // TODO ver si es DNI, CUIT, CUIL, etc.
        $resultado .= '80'; //CUIT

        //Número de identificación del comprador
        $resultado .= str_pad(str_replace('-', '', $comprobante->cliente_cuit), 20, '0', STR_PAD_LEFT);

        //Apellido y nombre o denominación del comprador
        $resultado .= str_pad(mb_convert_encoding($comprobante->cliente_nombre, "WINDOWS-1252", "UTF-8"), 30, ' ', STR_PAD_RIGHT);

        //Importe total de la operación
        $resultado .= str_pad(strval((int)(100 * $comprobante->importe_total)), 15, '0', STR_PAD_LEFT);

        //Importe total de conceptos que no integran el precio neto gravado
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Percepción a no categorizados
        // TODO ver estos importes
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Importe de operaciones exentas
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Importe de percepciones o pagos a cuenta de impuestos Nacionales
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Importe de percepciones de Ingresos Brutos
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Importe de percepciones impuestos Municipales
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Importe impuestos internos
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Código de moneda
        $resultado .= 'PES';

        //Tipo de cambio
        $resultado .= str_pad(strval((int)(1000000 * 1)), 10, '0', STR_PAD_LEFT);

        //Cantidad de alícuotas de IVA
        $resultado .= '1';

        //Código de operación
        $resultado .= ' ';

        //Otros Tributos
        $resultado .= str_pad(strval((int)(100 * 0)), 15, '0', STR_PAD_LEFT);

        //Fecha de Vencimiento de Pago
        $resultado .= '00000000';

        return($resultado);
    }

    protected function reginfo_alicuota($comprobante)
    {
        $resultado = '';

        //Tipo de comprobante
        switch ($comprobante->tipo_comprobante->codigo) {
            case 'FCA':
                $resultado .= '001';
                break;
            case 'FCB':
                $resultado .= '006';
                break;
            case 'FCC':
                $resultado .= '011';
                break;
            case 'NDA':
                $resultado .= '002';
                break;
            case 'NDB':
                $resultado .= '007';
                break;
            case 'NDC':
                $resultado .= '012';
                break;
            case 'NCA':
                $resultado .= '003';
                break;
            case 'NCB':
                $resultado .= '008';
                break;
            case 'NCC':
                $resultado .= '014';
                break;
        }

        //Punto de venta
        $resultado .= str_pad(strval($comprobante->punto_venta), 5, '0', STR_PAD_LEFT);

        //Número de comprobante
        $resultado .= str_pad(strval($comprobante->numero), 20, '0', STR_PAD_LEFT);

        //Importe neto gravado
        $resultado .= str_pad(strval((int)(100 * $comprobante->importe_neto)), 15, '0', STR_PAD_LEFT);

        //Alícuota de IVA
        $resultado .= '0005';

        //Impuesto Liquidado
        $resultado .= str_pad(strval((int)(100 * $comprobante->importe_iva)), 15, '0', STR_PAD_LEFT);

        return $resultado;
    }
}