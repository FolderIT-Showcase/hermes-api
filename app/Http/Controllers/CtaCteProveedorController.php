<?php

namespace App\Http\Controllers;

use App\CtaCteProveedor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CtaCteProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_cta_cte', ['only' => ['showByProvDate']]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param CtaCteProveedor $ctaCteProveedor
     */
    public function showByProvDate(Request $request)
    {
        $proveedor_id = $request->input('proveedor_id', '0');
        $fecha_inicio = $request->input('fecha_inicio', '0');
        $fecha_fin = $request->input('fecha_fin', '0');

//        $fecha_inicio_default = Carbon::create(1928, 1, 1, 0, 0, 0)->format('yyyy-MM-dd');
//        $fecha_fin_default = Carbon::today()->format('yyyy-MM-dd');

        $compr = CtaCteProveedor::where('proveedor_id', $proveedor_id)->orderBy('fecha', 'ASC')->orderBy('updated_at', 'ASC')->with('tipo_comp_compras')->with('comprobante_compras');

        if($fecha_inicio != '0' && $fecha_fin != '0'){
            $compr = $compr->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        }

        return response()->json($compr->get());
    }
}