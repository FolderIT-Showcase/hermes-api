<?php

namespace App\Http\Controllers;

use App\Comprobante;
use App\Contador;
use Illuminate\Support\Facades\DB;

class ComprobanteController extends Controller
{
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
}
