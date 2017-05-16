<?php

namespace App\Http\Controllers;

use App\ListaPrecios;
use Illuminate\Http\Request;

class ListaPreciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ListaPrecios::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newLista = ListaPrecios::create($request->json()->all());
        return response()->json($newLista);
    }

    /**
     * Display the specified resource.
     *
     * @param ListaPrecios $listaprecio
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPrecios $listaprecio)
    {
        return response()->json($listaprecio);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ListaPrecios $listaprecio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPrecios $listaprecio)
    {
        $listaprecio->fill($request->json()->all())->save();
        return response()->json($listaprecio);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ListaPrecios $listaprecio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaPrecios $listaprecio)
    {
        $listaprecio->delete();
        return response()->json('ok', 200);
    }
}
