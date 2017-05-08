<?php

namespace App\Http\Controllers;

use App\TipoComprobante;

class TipoComprobanteController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByTipoResponsable($cod)
    {
        switch ($cod){
            case 'RI': $codigo = 'FCA';
                break;
            case 'CF': $codigo = 'FCB';
                break;
            case 'MON': $codigo = 'FCB';
                break;
            default: $codigo = 'FCC';
        }

        $tipoComprobante = TipoComprobante::where('codigo', $codigo)->first();
        if($tipoComprobante === null){
            return response()->json('', 204);
        }
        else return response()->json($tipoComprobante);
    }
}
