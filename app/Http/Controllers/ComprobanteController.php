<?php

namespace App\Http\Controllers;

use App\Comprobante;
use App\ComproItem;
use App\Contador;
use App\Parametro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use JasperPHP\JasperPHP as JasperPHP;

class ComprobanteController extends Controller
{
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
            ->get()
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
        return response()->json($comprobante->load('cliente')->load('items.articulo'));
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
     * @param Comprobante $comprobante
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function imprimirPresupuesto($comprobante_id)
    {
        $jasper = new JasperPHP;

        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $COMPROBANTE_ID = '"' . $comprobante_id . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/presupuesto' . $comprobante_id . time();

        $jasper->process(
            base_path() . '/resources/assets/reports/presupuesto.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "COMPROBANTE_ID" => $COMPROBANTE_ID,
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return response()->download($output_path . '.pdf', 'presupuesto_' . $comprobante_id . '.pdf')->deleteFileAfterSend(true);
    }
}
