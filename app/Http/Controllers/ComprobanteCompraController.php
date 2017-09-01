<?php

namespace App\Http\Controllers;


use App\ComprobanteCompra;
use App\ComprobanteCompraRetenciones;
use App\CtaCteProveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprobanteCompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_facturaCompra', ['only' => ['show']]);
        $this->middleware('permission:create_facturaCompra', ['only' => ['store']]);
        $this->middleware('permission:edit_facturaCompra', ['only' => ['update']]);
        $this->middleware('permission:delete_facturaCompra', ['only' => ['destroy']]);

        $this->middleware('permission:view_notaCreditoCompra', ['only' => ['show']]);
        $this->middleware('permission:create_notaCreditoCompra', ['only' => ['store']]);
        $this->middleware('permission:edit_notaCreditoCompra', ['only' => ['update']]);
        $this->middleware('permission:delete_notaCreditoCompra', ['only' => ['destroy']]);

        $this->middleware('permission:view_notaDebitoCompra', ['only' => ['show']]);
        $this->middleware('permission:create_notaDebitoCompra', ['only' => ['store']]);
        $this->middleware('permission:edit_notaDebitoCompra', ['only' => ['update']]);
        $this->middleware('permission:delete_notaDebitoCompra', ['only' => ['destroy']]);
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
        // filtrar por estos parametros
        $proveedor = $request->input('proveedor', '0');
        $tipo = $request->input('tipo', '0');
        $periodo = $request->input('periodo', '0');
        $montomax = $request->input('montomax', '-1');
        $montomin = $request->input('montomin', '-1');

        $compr = ComprobanteCompra::orderBy('id', 'ASC');

        if($proveedor != '0'){
            $compr = $compr->where('proveedor_id', '=', $proveedor);
        }
        if($tipo != '0'){
            $compr = $compr->where('tipo_comp_compras_id', '=', $tipo);
        }
        if($periodo != '0'){
            $compr = $compr->where('periodo_id', '=', $periodo);
        }
        if($montomin != -1){
            $compr = $compr->where('importe_total', '>=', $montomin);
        }
        if($montomax != -1){
            $compr = $compr->where('importe_total', '<=', $montomax);
        }

        $result = $compr->get()->load('proveedor')->load('tipo_comp_compras')->load('periodo')->load('comprobante_compra_importes')->load('comprobante_compra_retenciones');

        if($result === null){
            return response()->json('', 204);
        }
        else return response()->json($result);
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

            //Actualizo tambien la referencia al ComprobanteCompra que hay en CuentaCorrienteProveedor
            $ctaCte = $this->updateCtaCteProv($comprobantecompra);
            $ctaCte->save();
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

    private function updateCtaCteProv(ComprobanteCompra $comprobantecompra): CtaCteProveedor
    {
        $ctaCte = CtaCteProveedor::where('comprobante_compras_id', $comprobantecompra->id)->first();

        $ctaCte->proveedor_id = $comprobantecompra->proveedor_id;
        $ctaCte->comprobante_compras_id = $comprobantecompra->id;
        $ctaCte->tipo_comp_compras_id = $comprobantecompra->tipo_comp_compras_id;
        $ctaCte->fecha = $comprobantecompra->fecha;
        $ctaCte->descripcion = $comprobantecompra->tipo_comp_compras->codigo . '-';

        switch (substr($comprobantecompra->tipo_comp_compras->codigo, 0, 2)) {
            case 'FC':case 'ND':
            $ctaCte->debe = $comprobantecompra->importe_total;
            $ctaCte->haber = 0.00;
            break;
            case 'NC':
                $ctaCte->debe = 0.00;
                $ctaCte->haber = $comprobantecompra->importe_total;
                break;
            default:
        }

        return $ctaCte;
    }
}