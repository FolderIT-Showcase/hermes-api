<?php

namespace App\Http\Controllers;

use App\Contador;

class ContadorController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $punto_venta
     * @param $tipo_comprobante_id
     * @return \Illuminate\Http\Response
     */
    public function showByPuntoVentaTipoComprobante($punto_venta, $tipo_comprobante_id)
    {
        $contador = Contador::where('punto_venta', $punto_venta)->where('tipo_comprobante_id', $tipo_comprobante_id)->first();
        if($contador === null){
            return response()->json('', 204);
        }
        else return response()->json($contador);
    }
}
