<?php

namespace App\Http\Controllers;


use App\ComprobanteCompra;
use App\ComprobanteCompraImportes;
use App\ComprobanteCompraRetenciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprobanteCompraController extends Controller
{
    public function __construct()
    {
        // TODO cargar permisos
        $this->middleware('permission:view_facturaCompra', ['only' => ['show']]);
        $this->middleware('permission:create_facturaCompra', ['only' => ['store']]);
        $this->middleware('permission:edit_facturaCompra', ['only' => ['update']]);
        $this->middleware('permission:delete_facturaCompra', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // se devuelven ordenados por fecha, del mas reciente al mas antiguo
        return response()->json(ComprobanteCompra::orderBy('fecha', 'ASC')->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones'));
    }

    /**
     * Display the specified resource.
     *
     * @param ComprobanteCompra $comprobantecompra
     * @return \Illuminate\Http\Response
     */
    public function show(ComprobanteCompra $comprobantecompra)
    {
        return response()->json($comprobantecompra->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones'));
    }

    /**
     * Display the specified resource.
     *
     * @param $tipocomp
     * @return \Illuminate\Http\Response
     */
    public function showByTipoComprobante($tipocomp)
    {
        $comprobantes =ComprobanteCompra::whereHas(
            'tipo_comp_compras', function ($query) use ($tipocomp) {
                $query->where('id', '=', $tipocomp);
            }
        )->get()->load('proveedor')->load('tipo_comp_compras')->load('periodo')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

        if($comprobantes === null){
            return response()->json('', 204);
        }
        else {
            return response()->json($comprobantes);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $prov
     * @return \Illuminate\Http\Response
     */
    public function showByProveedor($prov)
    {
        $comprobantes =ComprobanteCompra::whereHas(
            'proveedor', function ($query) use ($prov) {
            $query->where('id', '=', $prov);
        }
        )->get()->load('proveedor')->load('tipo_comp_compras')->load('periodo')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

        if($comprobantes === null){
            return response()->json('', 204);
        }
        else {
            return response()->json($comprobantes);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $per
     * @return \Illuminate\Http\Response
     */
    public function showByPeriodo($per)
    {
        $comprobantes =ComprobanteCompra::whereHas(
            'periodo', function ($query) use ($per) {
            $query->where('id', '=', $per);
        }
        )->get()->load('proveedor')->load('tipo_comp_compras')->load('periodo')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

        if($comprobantes === null){
            return response()->json('', 204);
        }
        else {
            return response()->json($comprobantes);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showByAll(Request $request)
    {
        // filtrar por estos 3 parametros
        $proveedor = $request->input('proveedor', '0');
        $tipo = $request->input('tipo', '0');
        $periodo = $request->input('periodo', '0');

        // si los tres parametros son no-nulos, hago la query completa
        if($proveedor != 0 && $tipo != 0 && $periodo != 0) {
            $comprobantes = ComprobanteCompra::whereHas(
                'tipo_comp_compras', function ($q) use ($tipo) {
                $q->where('id', '=', $tipo);
            }
            )
                ->whereHas('proveedor', function ($q) use ($proveedor) {
                    $q->where('id', '=',$proveedor);
                })
                ->whereHas('periodo', function ($q) use ($periodo) {
                    $q->where('id', '=', $periodo);
                })
                ->with('comprobante_compra_importes')
                ->with('comprobante_compra_retenciones')
                ->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

            if($comprobantes === null){
                return response()->json('', 204);
            }
            else return response()->json($comprobantes);
        }
        else {
            //algun filtro es nulo
            if($proveedor != 0) {
                if($tipo != 0) {
                    // filtro por proveedor y tipo (periodo es nulo)
                    $comprobantes = ComprobanteCompra::whereHas(
                        'tipo_comp_compras', function ($q) use ($tipo) {
                        $q->where('id', '=', $tipo);
                    }
                    )
                        ->whereHas('proveedor', function ($q) use ($proveedor) {
                            $q->where('id', '=',$proveedor);
                        })
                        ->with('comprobante_compra_importes')
                        ->with('comprobante_compra_retenciones')
                        ->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

                    if($comprobantes === null){
                        return response()->json('', 204);
                    }
                    else return response()->json($comprobantes);
                }
                else {
                    if($periodo != 0){
                        // filtro por proveedor y periodo (tipo es nulo)
                        $comprobantes = ComprobanteCompra::whereHas(
                            'periodo', function ($q) use ($periodo) {
                            $q->where('id', '=', $periodo);
                        }
                        )
                            ->whereHas('proveedor', function ($q) use ($proveedor) {
                                $q->where('id', '=',$proveedor);
                            })
                            ->with('comprobante_compra_importes')
                            ->with('comprobante_compra_retenciones')
                            ->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

                        if($comprobantes === null){
                            return response()->json('', 204);
                        }
                        else return response()->json($comprobantes);
                    }
                    else {
                        // filtro solo por proveedor (los otros dos son nulos)
                        $comprobantes =ComprobanteCompra::whereHas(
                            'proveedor', function ($query) use ($proveedor) {
                            $query->where('id', '=', $proveedor);
                        }
                        )->get()->load('proveedor')->load('tipo_comp_compras')->load('periodo')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

                        if($comprobantes === null){
                            return response()->json('', 204);
                        }
                        else {
                            return response()->json($comprobantes);
                        }
                    }
                }
            }
            else {
                if($periodo != 0){
                    if($tipo != 0){
                        //filtro por tipo y por periodo (proveedor es nulo)
                        $comprobantes = ComprobanteCompra::whereHas(
                            'tipo_comp_compras', function ($q) use ($tipo) {
                            $q->where('id', '=', $tipo);
                        }
                        )
                            ->whereHas('periodo', function ($q) use ($periodo) {
                                $q->where('id', '=',$periodo);
                            })
                            ->with('comprobante_compra_importes')
                            ->with('comprobante_compra_retenciones')
                            ->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

                        if($comprobantes === null){
                            return response()->json('', 204);
                        }
                        else return response()->json($comprobantes);
                    }
                    else{
                        // filtro solo por periodo (proveedor y tipo son nulos)
                        $comprobantes = ComprobanteCompra::whereHas('periodo', function ($q) use ($periodo) {
                                $q->where('id', '=', $periodo);
                            })
                            ->with('comprobante_compra_importes')
                            ->with('comprobante_compra_retenciones')
                            ->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

                        if($comprobantes === null){
                            return response()->json('', 204);
                        }
                        else return response()->json($comprobantes);
                    }
                }
                else{
                    // filtro solo por tipo (proveedor y periodo son nulos)
                    $comprobantes = ComprobanteCompra::whereHas(
                        'tipo_comp_compras', function ($q) use ($tipo) {
                        $q->where('id', '=', $tipo);
                    }
                    )
                        ->with('comprobante_compra_importes')
                        ->with('comprobante_compra_retenciones')
                        ->get()->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

                    if($comprobantes === null){
                        return response()->json('', 204);
                    }
                    else return response()->json($comprobantes);
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $newComprobanteCompra = (new ComprobanteCompra())->fill($data);
        $importes = $data['comprobante_compra_importes'];
        $retenciones = $data['comprobante_compra_retenciones'];

        $compr = ComprobanteCompra::where('tipo_comp_compras_id', $newComprobanteCompra->tipo_comp_compras_id)
            ->where('punto_venta', $newComprobanteCompra->punto_venta)
            ->where('numero', $newComprobanteCompra->numero)
            ->first();

        if($compr !== null) {
            return response()->json(['error' => 'No se puede volver a generar el mismo comprobante'],200);
        }

        DB::transaction(function () use ($newComprobanteCompra, $importes, $retenciones) {
            $newComprobanteCompra->save();
            $newComprobanteCompra->comprobante_compra_importes()->create($importes);
            foreach ($retenciones as $retencion){
                $newComprobanteCompra->comprobante_compra_retenciones()->create($retencion);
            }
        });

        return response()->json($newComprobanteCompra->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ComprobanteCompra $comprobantecompra
     * @return \Illuminate\Http\Response
     */
    public function update(ComprobanteCompra $comprobantecompra)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        DB::transaction(function () use ($data, $comprobantecompra) {
            $comprobantecompra->fill($data)->save();

            $importes = $data['comprobante_compra_importes'];
            $comprobantecompra->comprobante_compra_importes()->update($importes);

            $comprobantecompra->load('comprobante_compra_retenciones');
            $viejasretenciones = $comprobantecompra['comprobante_compra_retenciones'];
            $nuevasretenciones = $data['comprobante_compra_retenciones'];

            //Se borran las retenciones que no vinieron en el request
            $retencionesABorrar = $viejasretenciones->whereNotIn('id', array_column($nuevasretenciones, 'id'))->all();
            ComprobanteCompraRetenciones::destroy(array_column($retencionesABorrar, 'id'));

            //de las que quedaron, se crean o actualizan segun si ya tienen id
            foreach ($nuevasretenciones as $ret){
                $comprobantecompra->comprobante_compra_retenciones()->updateOrCreate(['id'=>(isset($ret['id'])? $ret['id'] : 0)], $ret);
            }
        });

        return response()->json($comprobantecompra->load('proveedor')->load('periodo')->load('tipo_comp_compras')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ComprobanteCompra $comprobantecompra
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComprobanteCompra $comprobantecompra)
    {
        DB::transaction(function () use ($comprobantecompra) {
            $comprobantecompra->comprobante_compra_importes()->delete();
            $comprobantecompra->comprobante_compra_retenciones()->delete();
            $comprobantecompra->delete();
        });
        return response()->json('ok', 200);
    }
}