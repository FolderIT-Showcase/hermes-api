<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Marca::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newMarca = Marca::create($request->json()->all());
        return response()->json($newMarca);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        return response()->json($marca);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        $marca->fill($request->json()->all())->save();
        return response()->json($marca);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        if($marca->articulos()->count() !== 0){
            return response()->json(['error' => 'No se ha podido eliminar la marca ' . $marca->codigo . ' porque existen artículos asociados'], 200);
        };
        $marca->delete();
        return response()->json('ok', 200);    }
    
    /**
     * Display the specified resource.
     *
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByCode($cod)
    {
        $marca = Marca::where('codigo', $cod)->first();
        if($marca === null){
            return response()->json('', 204);
        }
        else return response()->json($marca);
    }
}
