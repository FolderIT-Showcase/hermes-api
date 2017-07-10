<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Comprobante;
use App\ComproItem;
use App\Contador;
use App\Parametro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use JasperPHP\JasperPHP as JasperPHP;
use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_presupuesto', ['only' => ['indexPresupuestos', 'show', 'imprimir', 'generarPDFPresupuesto', 'enviarMailPresupuesto', 'showByTypeDate']]);
        $this->middleware('permission:create_presupuesto', ['only' => ['store']]);
        $this->middleware('permission:edit_presupuesto', ['only' => ['update']]);
        $this->middleware('permission:delete_presupuesto', ['only' => ['destroy']]);

        $this->middleware('permission:view_factura', ['only' => ['show', 'imprimir', 'generarPDFFactura', 'showByTypeDate']]);
        $this->middleware('permission:create_factura', ['only' => ['store']]);
        $this->middleware('permission:edit_factura', ['only' => ['update']]);
        $this->middleware('permission:delete_factura', ['only' => ['destroy']]);

        $this->middleware('permission:view_nota_debito', ['only' => ['show', 'imprimir', 'generarPDFNotaCreditoDebito', 'showByTypeDate']]);
        $this->middleware('permission:create_nota_debito', ['only' => ['store']]);
        $this->middleware('permission:edit_nota_debito', ['only' => ['update']]);
        $this->middleware('permission:delete_nota_debito', ['only' => ['destroy']]);

        $this->middleware('permission:view_nota_credito', ['only' => ['show', 'imprimir', 'generarPDFNotaCreditoDebito', 'showByTypeDate']]);
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

    /**
     * Generate report
     * @param $comprobante_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function imprimir($comprobante_id)
    {
        $comprobante = Comprobante::where('id', $comprobante_id)->first();
        $cod_tipo_comprobante = $comprobante->tipo_comprobante->codigo;
        $output_path = '';
        switch (substr($cod_tipo_comprobante, 0 , 2)){
            case 'FC':
                $output_path = $this->generarPDFFactura($comprobante_id);
                break;
            case 'ND':
            case 'NC':
                $output_path = $this->generarPDFNotaCreditoDebito($comprobante_id);
                break;
            case 'PR':
                $output_path = $this->generarPDFPresupuesto($comprobante_id);
                break;
        }

        return response()->download($output_path . '.pdf', 'comprobante' . $comprobante_id . '.pdf')->deleteFileAfterSend(true);
    }

    private function generarPDFPresupuesto($comprobante_id)
    {
        $jasper = new JasperPHP;

        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $COMPROBANTE_ID = '"' . $comprobante_id . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/factura' . $comprobante_id . time();
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $domicilioCliente = Comprobante::where('id', $comprobante_id)->first()->cliente->domicilios[0];
        $CLIENTE_DOMICILIO = '"' . $domicilioCliente->direccion . ' - '
            . $domicilioCliente->localidad->nombre . ' , '
            . $domicilioCliente->localidad->provincia->nombre . '"';
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
                  "CLIENTE_DOMICILIO" => $CLIENTE_DOMICILIO
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return $output_path;
    }

    private function generarPDFFactura($comprobante_id)
    {
        $jasper = new JasperPHP;

        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $COMPROBANTE_ID = '"' . $comprobante_id . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/factura' . $comprobante_id . time();
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $domicilioCliente = Comprobante::where('id', $comprobante_id)->first()->cliente->domicilios[0];
        $CLIENTE_DOMICILIO = '"' . $domicilioCliente->direccion . ' - '
            . $domicilioCliente->localidad->nombre . ' , '
            . $domicilioCliente->localidad->provincia->nombre . '"';
        $jasper->process(
            base_path() . '/resources/assets/reports/factura.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "COMPROBANTE_ID" => $COMPROBANTE_ID,
                  "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                  "EMPRESA_DIRECCION" => $EMPRESA_DOMICILIO,
                  "EMPRESA_CUIT" => $EMPRESA_CUIT,
                  "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP,
                  "CLIENTE_DOMICILIO" => $CLIENTE_DOMICILIO
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return $output_path;
    }

    private function generarPDFNotaCreditoDebito($comprobante_id)
    {
        $jasper = new JasperPHP;

        $comprobante = Comprobante::where('id', $comprobante_id)->first();

        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $COMPROBANTE_ID = '"' . $comprobante_id . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/nota_debito_credito' . $comprobante_id . time();
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $domicilioCliente = $comprobante->cliente->domicilios[0];
        $CLIENTE_DOMICILIO = '"' . $domicilioCliente->direccion . ' - '
            . $domicilioCliente->localidad->nombre . ' , '
            . $domicilioCliente->localidad->provincia->nombre . '"';
        $TITULO = '"' . ((strpos($comprobante->tipo_comprobante->codigo, 'ND') !== false)? "NOTA DE DÉBITO": "NOTA DE CRÉDITO") . '"';
        $jasper->process(
            base_path() . '/resources/assets/reports/nota_debito_credito.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "COMPROBANTE_ID" => $COMPROBANTE_ID,
                  "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                  "EMPRESA_DIRECCION" => $EMPRESA_DOMICILIO,
                  "EMPRESA_CUIT" => $EMPRESA_CUIT,
                  "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP,
                  "CLIENTE_DOMICILIO" => $CLIENTE_DOMICILIO,
                  "TITULO" => $TITULO
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return $output_path;
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param CtaCteCliente $ctaCteCliente
     */
    public function showByTypeDate(Request $request)
    {
        $tipo = $request->input('tipo_comprobante', '0');
        $fecha_inicio = $request->input('fecha_inicio', Carbon::create(1928, 1, 1, 0, 0, 0)->format('yyyy-MM-dd'));
        $fecha_fin = $request->input('fecha_fin', Carbon::today()->format('yyyy-MM-dd'));

        if($tipo !== '0') {
            $comprobantes = Comprobante::where('tipo_comprobante_id', $tipo)
                ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                ->orderBy('fecha', 'ASC')
                ->orderBy('updated_at', 'ASC')
                ->with('tipo_comprobante')
                ->get();
        } else {
            $comprobantes = Comprobante::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                ->orderBy('fecha', 'ASC')
                ->orderBy('updated_at', 'ASC')
                ->with('tipo_comprobante')
                ->get();
        }

        return response()->json($comprobantes);
    }
}
