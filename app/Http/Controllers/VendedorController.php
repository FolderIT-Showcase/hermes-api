<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Vendedor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newVendedor = Vendedor::create($request->json()->all());
        return response()->json($newVendedor);
    }

    /**
     * Display the specified resource.
     *
     * @param Vendedor $vendedor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendedor $vendedor)
    {
        return response()->json($vendedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Vendedor $vendedor
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Vendedor $vendedor, Request $request)
    {
        $vendedor->fill($request->json()->all())->save();
        return response()->json($vendedor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Vendedor $vendedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendedor $vendedor)
    {
        if($vendedor->clientes()->count() !== 0){
            return response()->json(['error' => 'No se ha podido eliminar al vendedor ' . $vendedor->nombre . ' porque existen clientes asociados'], 200);
        };
        $vendedor->delete();
        return response()->json('ok', 200);
    }
}
