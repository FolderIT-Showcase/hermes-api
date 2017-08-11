<?php

namespace App\Http\Controllers;

use App\Comprobante;
use Illuminate\Http\Request;

class CobroController extends Controller
{
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
