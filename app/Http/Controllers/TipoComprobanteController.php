<?php

namespace App\Http\Controllers;

use App\Comprobante;
use App\TipoComprobante;
use Carbon\Carbon;

class TipoComprobanteController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $tipo_comprobante
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByTipoResponsable($tipo_comprobante, $cod)
    {
        switch ($tipo_comprobante) {
            case 'factura':
                switch ($cod){
                    case 'RI': $codigo = 'FCA';
                        break;
                    case 'CF': $codigo = 'FCB';
                        break;
                    case 'MON': $codigo = 'FCB';
                        break;
                    default: $codigo = 'FCC';
                }
                break;
            case 'presupuesto':
                $codigo = 'PRX';
                break;
            case 'nota_debito':
                switch ($cod){
                    case 'RI': $codigo = 'NDA';
                        break;
                    case 'CF': $codigo = 'NDB';
                        break;
                    case 'MON': $codigo = 'NDB';
                        break;
                    default: $codigo = 'NDC';
                }
                break;
            case 'nota_credito':
                switch ($cod){
                    case 'RI': $codigo = 'NCA';
                        break;
                    case 'CF': $codigo = 'NCB';
                        break;
                    case 'MON': $codigo = 'NCB';
                        break;
                    default: $codigo = 'NCC';
                }
                break;
            default:
                $codigo = 'FCC';
        }

        $tipoComprobante = TipoComprobante::where('codigo', $codigo)->first();
        if($tipoComprobante === null){
            return response()->json('', 204);
        }
        else {
            $ultimoComprobante = Comprobante::where('tipo_comprobante_id', $tipoComprobante->id)->orderBy('fecha', 'DESC')->first();
            if($ultimoComprobante === null){
                $tipoComprobante->ultima_fecha = '1900-01-01';
            }
            else {
                $tipoComprobante->ultima_fecha = Carbon::createFromFormat('Y-m-d', $ultimoComprobante->fecha)->subDay()->format('Y-m-d');
            }
            return response()->json($tipoComprobante);
        }
    }
}
