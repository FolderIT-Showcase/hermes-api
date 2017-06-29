<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Comprobante;
use App\ComproItem;
use App\Contador;
use App\Parametro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use JasperPHP\JasperPHP as JasperPHP;

class ComprobanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_presupuesto', ['only' => ['indexPresupuestos', 'show', 'imprimirPresupuesto', 'generarPDFPresupuesto', 'enviarMailPresupuesto']]);
        $this->middleware('permission:create_presupuesto', ['only' => ['store']]);
        $this->middleware('permission:edit_presupuesto', ['only' => ['update']]);
        $this->middleware('permission:delete_presupuesto', ['only' => ['destroy']]);

        $this->middleware('permission:view_factura', ['only' => ['show']]);
        $this->middleware('permission:create_factura', ['only' => ['store']]);
        $this->middleware('permission:edit_factura', ['only' => ['update']]);
        $this->middleware('permission:delete_factura', ['only' => ['destroy']]);

        $this->middleware('permission:view_nota_debito', ['only' => ['show']]);
        $this->middleware('permission:create_nota_debito', ['only' => ['store']]);
        $this->middleware('permission:edit_nota_debito', ['only' => ['update']]);
        $this->middleware('permission:delete_nota_debito', ['only' => ['destroy']]);

        $this->middleware('permission:view_nota_credito', ['only' => ['show']]);
        $this->middleware('permission:create_nota_credito', ['only' => ['store']]);
        $this->middleware('permission:edit_nota_credito', ['only' => ['update']]);
        $this->middleware('permission:delete_nota_credito', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPresupuestos()
    {
        return response()->json(Comprobante::whereHas(
            'tipo_comprobante', function ($query) {
            $query->where('codigo', 'like', 'PR_');
        }
        )
            ->get()->load('cliente')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Comprobante $comprobante
     * @return \Illuminate\Http\Response
     */
    public function show(Comprobante $comprobante)
    {
        return response()->json($comprobante->load('cliente')->load('items.articulo')->load('tipo_comprobante'));
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $newComprobante = (new Comprobante())->fill($data);
        $items = $data['items'];

        $compr = Comprobante::where('tipo_comprobante_id', $newComprobante->tipo_comprobante_id)
            ->where('punto_venta', $newComprobante->punto_venta)
            ->where('numero', $newComprobante->numero)
            ->first();

        if($compr !== null) {
            return response()->json(['error' => 'No se puede volver a generar el mismo comprobante'],200);
        }

        DB::transaction(function () use ($items, $newComprobante) {
            $newComprobante->save();
            foreach ($items as $item){
                $newComprobante->items()->create($item);
            }
            $contador = Contador::where('tipo_comprobante_id', $newComprobante->tipo_comprobante_id)
                ->where('punto_venta', $newComprobante->punto_venta)->first();
            $contador->ultimo_generado = $newComprobante->numero;
            $contador->save();
        });

        return response()->json($newComprobante->load('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Comprobante $comprobante
     * @return \Illuminate\Http\Response
     */
    public function update(Comprobante $comprobante)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        DB::transaction(function () use ($data, $comprobante) {
            $comprobante->fill($data)->save();
            $comprobante->load('items');

            $viejosItems = $comprobante['items'];
            $nuevosItems = $data['items'];

            //Se borran los items que no vinieron en el request
            $itemsABorrar = $viejosItems->whereNotIn('id', array_column($nuevosItems, 'id'))->all();
            ComproItem::destroy(array_column($itemsABorrar, 'id'));

            //Se actualiza o se crea un domicilio segun si tiene seteado o no el id
            foreach ($nuevosItems as $item){
                $comprobante->items()->updateOrCreate(['id'=>(isset($item['id'])? $item['id'] : 0)], $item);
            }
        });

        return response()->json($comprobante->load('items'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comprobante $comprobante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comprobante $comprobante)
    {
        DB::transaction(function () use ($comprobante) {
            $comprobante->items()->delete();
            $comprobante->delete();
        });
        return response()->json('ok', 200);
    }

    /**
     * Generate report
     * @param $comprobante_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function imprimirPresupuesto($comprobante_id)
    {
        $output_path = $this->generarPDFPresupuesto($comprobante_id);

        return response()->download($output_path . '.pdf', 'presupuesto_' . $comprobante_id . '.pdf')->deleteFileAfterSend(true);
    }

    /**
     * Generate report
     * @param $comprobante_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function enviarMailPresupuesto($comprobante_id)
    {
        $output_path = $this->generarPDFPresupuesto($comprobante_id);
        $comprobante = Comprobante::where('id', $comprobante_id)->first();
        $cliente = Cliente::where('id', $comprobante->cliente_id)->first();
        //TODO hacer una plantilla de email más linda
        $email_text = 'Buenas tardes ' . $comprobante->cliente_nombre . ', le enviamos el presupuesto solicitado como archivo adjunto.';

        Mail::raw($email_text, function($message) use ($cliente, $output_path) {
            //TODO setear el from según algún parámetro
            $message->from('hermesweb@folderit.net', Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor);
            $message->to($cliente->email);
            $message->subject('Presupuesto');
            $message->attach($output_path . '.pdf', ['as' => 'Presupuesto.pdf', 'mime' => 'application/pdf']);
        });

        File::delete($output_path . '.pdf');

        return response()->json('ok');
    }

    private function generarPDFPresupuesto($comprobante_id)
    {
        $jasper = new JasperPHP;

        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $COMPROBANTE_ID = '"' . $comprobante_id . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/presupuesto' . $comprobante_id . time();
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $jasper->process(
            base_path() . '/resources/assets/reports/presupuesto.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "COMPROBANTE_ID" => $COMPROBANTE_ID,
                  "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                  "EMPRESA_DIRECCION" => $EMPRESA_DOMICILIO,
                  "EMPRESA_CUIT" => $EMPRESA_CUIT,
                  "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP,
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return $output_path;
    }
}
