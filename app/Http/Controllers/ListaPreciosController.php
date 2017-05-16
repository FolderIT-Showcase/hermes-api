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
     * @param  \App\ListaPrecios  $listaPrecios
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPrecios $listaPrecios)
    {
        return response()->json($listaPrecios);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListaPrecios  $listaPrecios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPrecios $listaPrecios)
    {
        $listaPrecios->fill($request->json()->all())->save();
        return response()->json($listaPrecios);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaPrecios  $listaPrecios
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaPrecios $listaPrecios)
    {
        $listaPrecios->delete();
        return response()->json('ok', 200);
    }
}
