<?php

namespace App\Http\Controllers;

use App\Subrubro;
use Illuminate\Http\Request;

class SubrubroController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_subrubro', ['only' => ['index', 'show', 'showByCode']]);
        $this->middleware('permission:create_subrubro', ['only' => ['store']]);
        $this->middleware('permission:edit_subrubro', ['only' => ['update']]);
        $this->middleware('permission:delete_subrubro', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Subrubro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newSubrubro = Subrubro::create($request->json()->all());
        return response()->json($newSubrubro);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subrubro  $subrubro
     * @return \Illuminate\Http\Response
     */
    public function show(Subrubro $subrubro)
    {
        return response()->json($subrubro);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subrubro  $subrubro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subrubro $subrubro)
    {
        $subrubro->fill($request->json()->all())->save();
        return response()->json($subrubro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subrubro  $subrubro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subrubro $subrubro)
    {
        if($subrubro->articulos()->count() !== 0){
            return response()->json(['error' => 'No se ha podido eliminar el subrubro ' . $subrubro->codigo . ' porque existen artículos asociados'], 200);
        };
        $subrubro->delete();
        return response()->json('ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByCode($cod)
    {
        $subrubro = Subrubro::where('codigo', $cod)->first();
        if($subrubro === null){
            return response()->json('', 204);
        }
        else return response()->json($subrubro);
    }
}
