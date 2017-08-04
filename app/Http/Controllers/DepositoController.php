<?php

namespace App\Http\Controllers;

use App\Deposito;
use Illuminate\Http\Request;

class DepositoController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:view_deposito', ['only' => ['index', 'show']]);
//        $this->middleware('permission:create_deposito', ['only' => ['store']]);
//        $this->middleware('permission:edit_deposito', ['only' => ['update']]);
//        $this->middleware('permission:delete_deposito', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Deposito::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newDeposito = Deposito::create($request->json()->all());
        return response()->json($newDeposito);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deposito  $deposito
     * @return \Illuminate\Http\Response
     */
    public function show(Deposito $deposito)
    {
        return response()->json($deposito);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposito  $deposito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposito $deposito)
    {
        $deposito->fill($request->json()->all())->save();
        return response()->json($deposito);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deposito  $deposito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposito $deposito)
    {
        // TODO chequear Integrity constraint violation
        $deposito->delete();
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
        $cliente = $request->input('cliente', '0');
        $fecha_inicio = $request->input('fecha_inicio', '0');
        $fecha_fin = $request->input('fecha_fin', '0');

        $tarjetas = Deposito::when($cliente !== '0',  function ($query) use ($cliente) {
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
