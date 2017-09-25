<?php

namespace App\Http\Controllers;

use App\ChequeTercero;
use App\ComprobanteCompra;
use App\CtaCteProveedor;
use App\OrdenPago;
use App\TipoComprobanteCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $newOrdenPago = (new OrdenPago())->fill($data);
        $items = $data['items'];
        $ordenPagoValores = $data['orden_pago_valores'];

        /*        $compr = Cobro::where('punto_venta', $newCobro->punto_venta)
                    ->where('numero', $newCobro->numero)
                    ->first();

                if($compr !== null) {
                    return response()->json(['error' => 'No se puede volver a generar el mismo comprobante'],200);
                }*/

        DB::transaction(function () use ($ordenPagoValores, $items, $newOrdenPago) {
            $newOrdenPago->save();

            foreach ($items as $item) {
                $savedItem = $newOrdenPago->orden_pago_items()->create($item);
                if (!$item['anticipo']) {
                    $comprobante_compra = $savedItem->comprobante_compra()->first();
                    $comprobante_compra->saldo -= $item['importe'];
                    $comprobante_compra->save();
                }
            }

            foreach ($ordenPagoValores as $ordenPagoValor) {
                $savedOrdenPagoValor = $newOrdenPago->orden_pago_valores()->create($ordenPagoValor);
                if (array_key_exists('cheques_propios', $ordenPagoValor)) {
                    foreach ($ordenPagoValor['cheques_propios'] as $cheque) {
                        $savedOrdenPagoValor->cheques_propios()->create($cheque);
                    }
                } else {
                    if (array_key_exists('depositos', $ordenPagoValor)) {
                        foreach ($ordenPagoValor['depositos'] as $deposito) {
                            $savedOrdenPagoValor->deposito()->create($deposito);
                        }
                    }  else {
                        if (array_key_exists('cheques_terceros', $ordenPagoValor)) {
                            foreach ($ordenPagoValor['cheques_terceros'] as $cheque) {
                                $dbCheque = ChequeTercero::where('id', $cheque['id'])->first();
                                $dbCheque->estado = 'T';
                                $dbCheque->save();
//                                    $savedOrdenPagoValor->deposito()->create($deposito);
                            }
                        }
                    }
                }
            }

            $ctaCteProveedor = new CtaCteProveedor();
            $ctaCteProveedor->proveedor_id = $newOrdenPago->proveedor_id;
            $ctaCteProveedor->tipo_comp_compras_id = TipoComprobanteCompra::where('codigo', 'REC')->first()->id;
            $ctaCteProveedor->fecha = $newOrdenPago->fecha;
            $ctaCteProveedor->descripcion = 'Pago proveedor';
            $ctaCteProveedor->debe = 0;
            $ctaCteProveedor->haber = $newOrdenPago->importe;
            $newOrdenPago->cta_cte_proveedor()->save($ctaCteProveedor);

//            $contador = Contador::where('punto_venta', $newOrdenPago->punto_venta)
//                ->whereHas('tipo_comprobante', function ($query) {
//                    $query->where('codigo', 'REC');
//                })->first();
//            $contador->ultimo_generado = $newOrdenPago->numero;
//            $contador->save();
        });

        return response()->json($newOrdenPago);
    }
}
