<?php

namespace App\Http\Controllers;

use App\TipoTarjeta;
use Illuminate\Http\Request;

class TipoTarjetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TipoTarjeta::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newTipoTarjeta = TipoTarjeta::create($request->json()->all());
        return response()->json($newTipoTarjeta);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoTarjeta  $tipoTarjeta
     * @return \Illuminate\Http\Response
     */
    public function show(TipoTarjeta $tipoTarjeta)
    {
        return response()->json($tipoTarjeta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoTarjeta  $tipoTarjeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoTarjeta $tipoTarjeta)
    {
        $tipoTarjeta->fill($request->json()->all())->save();
        return response()->json($tipoTarjeta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoTarjeta  $tipoTarjeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoTarjeta $tipoTarjeta)
    {
        // TODO chequear Integrity constraint violation
        $tipoTarjeta->delete();
        return response()->json('ok', 200);
    }
}
