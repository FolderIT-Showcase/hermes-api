<?php

namespace App\Http\Controllers;

use App\PuntoVenta;
use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(PuntoVenta::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newPuntoVenta = PuntoVenta::create($request->json()->all());
        return response()->json($newPuntoVenta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\PuntoVenta $puntoVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PuntoVenta $puntoVenta)
    {
        $puntoVenta->fill($request->json()->all())->save();
        return response()->json($puntoVenta);
    }

    public function listarHabilitados()
    {
        return response()->json(PuntoVenta::where('habilitado', true)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByCode($cod)
    {
        $puntoVenta = PuntoVenta::where('id', $cod)->first();
        if($puntoVenta === null){
            return response()->json('', 204);
        }
        else return response()->json($puntoVenta);
    }
}
