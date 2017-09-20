<?php

namespace App\Http\Controllers;

use App\ComprobanteCompra;
use Illuminate\Http\Request;

class OrdenPagoController extends Controller
{
    public function showComprobantes(Request $request)
    {
        $proveedor = $request->input('proveedor', '0');
        $comprobantes = ComprobanteCompra::where('proveedor_id', $proveedor)
            ->where('saldo', '>', 0)
            ->orderBy('fecha', 'ASC')
            ->get()
            ->load('tipo_comp_compras');
        return response()->json($comprobantes);
    }
}
