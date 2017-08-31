<?php

namespace App\Http\Controllers;

use App\Cobro;
use App\Comprobante;
use App\Contador;
use App\CtaCteCliente;
use App\TipoComprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view_cobro', ['only' => ['index', 'show', 'showComprobantes']]);
        $this->middleware('permission:create_cobro', ['only' => ['store']]);
        $this->middleware('permission:edit_cobro', ['only' => ['update']]);
        $this->middleware('permission:delete_cobro', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $newCobro = (new Cobro())->fill($data);
        $items = $data['items'];
        $cobroValores = $data['cobro_valores'];

/*        $compr = Cobro::where('punto_venta', $newCobro->punto_venta)
            ->where('numero', $newCobro->numero)
            ->first();

        if($compr !== null) {
            return response()->json(['error' => 'No se puede volver a generar el mismo comprobante'],200);
        }*/

        DB::transaction(function () use ($cobroValores, $items, $newCobro) {
            $newCobro->save();

            foreach ($items as $item) {
                $savedItem = $newCobro->cobro_items()->create($item);
                $comprobante = $savedItem->comprobante()->first();
                $comprobante->saldo -= $item['importe_total'];
                $comprobante->save();
            }

            foreach ($cobroValores as $cobroValor) {
                $savedCobroValor = $newCobro->cobro_valores()->create($cobroValor);
                if (array_key_exists('tarjetas', $cobroValor)) {
                    foreach ($cobroValor['tarjetas'] as $tarjeta) {
                        $savedCobroValor->tarjeta()->create($tarjeta);
                    }
                } else {
                    if (array_key_exists('cheques', $cobroValor)) {
                        foreach ($cobroValor['cheques'] as $cheque) {
                            $savedCobroValor->cheque()->create($cheque);
                        }
                    } else {
                        if (array_key_exists('depositos', $cobroValor)) {
                            foreach ($cobroValor['depositos'] as $deposito) {
                                $savedCobroValor->deposito()->create($deposito);
                            }
                        }
                    }
                }
            }

            $ctaCteCliente = new CtaCteCliente();
            $ctaCteCliente->cliente_id = $newCobro->cliente_id;
            $ctaCteCliente->tipo_comprobante_id = TipoComprobante::where('codigo', 'REC')->first()->id;
            $ctaCteCliente->fecha = $newCobro->fecha;
            $ctaCteCliente->descripcion = 'Pago cliente';
            $ctaCteCliente->debe = 0;
            $ctaCteCliente->haber = $newCobro->importe;
            $newCobro->ctaCteCliente()->save($ctaCteCliente);

            $contador = Contador::where('punto_venta', $newCobro->punto_venta)
                ->whereHas('tipo_comprobante', function ($query) {
                    $query->where('codigo', 'REC');
                })->first();
            $contador->ultimo_generado = $newCobro->numero;
            $contador->save();
        });

        return response()->json($newCobro);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showComprobantes(Request $request)
    {
        $cliente = $request->input('cliente', '0');
        $comprobantes = Comprobante::where('cliente_id', $cliente)
            ->where('saldo', '>', 0)
            ->whereHas(
                'tipo_comprobante', function ($query) {
                $query->where('codigo', 'not like', 'PR_');
            })
            ->orderBy('fecha', 'ASC')
            ->get()
            ->load('tipo_comprobante');
        return response()->json($comprobantes);
    }
}
