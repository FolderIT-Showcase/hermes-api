<?php

namespace App\Http\Controllers;

use App\CtaCteCliente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CtaCteClienteController extends Controller
{
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
            CtaCteCliente::where('cliente_id', $cliente_id)->whereBetween('fecha', [$fecha_inicio, $fecha_fin])->with('tipo_comprobante')->with('comprobante')->get()
        );
    }
}
