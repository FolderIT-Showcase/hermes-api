<?php

namespace App\Http\Controllers;

use App\ChequeTercero;
use Illuminate\Http\Request;

class ChequeTerceroController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_cheque_tercero', ['only' => ['index', 'show', 'showByAll']]);
        $this->middleware('permission:create_cheque_tercero', ['only' => ['store']]);
        $this->middleware('permission:edit_cheque_tercero', ['only' => ['update']]);
        $this->middleware('permission:delete_cheque_tercero', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ChequeTercero::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newChequeTercero = ChequeTercero::create($request->json()->all());
        return response()->json($newChequeTercero);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChequeTercero  $chequeTercero
     * @return \Illuminate\Http\Response
     */
    public function show(ChequeTercero $chequeTercero)
    {
        return response()->json($chequeTercero);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChequeTercero  $chequeTercero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChequeTercero $chequeTercero)
    {
        $chequeTercero->fill($request->json()->all())->save();
        return response()->json($chequeTercero);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChequeTercero  $chequeTercero
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChequeTercero $chequeTercero)
    {
        // TODO chequear Integrity constraint violation
        $chequeTercero->delete();
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
        $fecha_ingreso_inicio = $request->input('fecha_ingreso_inicio', '0');
        $fecha_ingreso_fin = $request->input('fecha_ingreso_fin', '0');

        $tarjetas = ChequeTercero::when($estado !== '0',  function ($query) use ($estado) {
            return $query->where('estado', $estado);})
            ->when($cliente !== '0',  function ($query) use ($cliente) {
                return $query->where('cliente_id', $cliente);})
            ->when($fecha_ingreso_inicio !== '0' && $fecha_ingreso_fin !== '0',  function ($query) use ($fecha_ingreso_inicio, $fecha_ingreso_fin) {
                return $query->whereBetween('fecha_ingreso', [$fecha_ingreso_inicio, $fecha_ingreso_fin]);})
            ->get();

        if($tarjetas === null){
            return response()->json('', 204);
        }
        else return response()->json($tarjetas);
    }
}
