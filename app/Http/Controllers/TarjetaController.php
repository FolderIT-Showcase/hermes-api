<?php

namespace App\Http\Controllers;

use App\Tarjeta;
use Illuminate\Http\Request;

class TarjetaController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:view_tarjeta', ['only' => ['index', 'show']]);
//        $this->middleware('permission:create_tarjeta', ['only' => ['store']]);
//        $this->middleware('permission:edit_tarjeta', ['only' => ['update']]);
//        $this->middleware('permission:delete_tarjeta', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Tarjeta::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newTarjeta = Tarjeta::create($request->json()->all());
        return response()->json($newTarjeta);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function show(Tarjeta $tarjeta)
    {
        return response()->json($tarjeta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarjeta $tarjeta)
    {
        $tarjeta->fill($request->json()->all())->save();
        return response()->json($tarjeta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarjeta $tarjeta)
    {
        // TODO chequear Integrity constraint violation
        $tarjeta->delete();
        return response()->json('ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showByAll(Request $request)
    {
        $estado = $request->input('estado', '0');
        $cliente = $request->input('cliente', '0');
        $fecha_inicio = $request->input('fecha_inicio', '0');
        $fecha_fin = $request->input('fecha_fin', '0');

        $tarjetas = Tarjeta::when($estado !== '0',  function ($query) use ($estado) {
                return $query->where('estado', $estado);})
            ->when($cliente !== '0',  function ($query) use ($cliente) {
                return $query->where('cliente_id', $cliente);})
            ->when($fecha_inicio !== '0' && $fecha_fin !== '0',  function ($query) use ($fecha_inicio, $fecha_fin) {
                return $query->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);})
            ->get();

        if($tarjetas === null){
            return response()->json('', 204);
        }
        else return response()->json($tarjetas);
    }
}
