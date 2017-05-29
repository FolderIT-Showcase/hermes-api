<?php

namespace App\Http\Controllers;

use App\TipoComprobante;

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
                switch ($cod){
                    case 'RI': $codigo = 'PRA';
                        break;
                    case 'CF': $codigo = 'PRB';
                        break;
                    case 'MON': $codigo = 'PRB';
                        break;
                    default: $codigo = 'PRC';
                }
                break;
            default:
                $codigo = 'FCC';
        }

        $tipoComprobante = TipoComprobante::where('codigo', $codigo)->first();
        if($tipoComprobante === null){
            return response()->json('', 204);
        }
        else return response()->json($tipoComprobante);
    }
}
