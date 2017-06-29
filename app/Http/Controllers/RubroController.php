<?php

namespace App\Http\Controllers;

use App\Rubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_rubro', ['only' => ['index', 'show', 'showByCode']]);
        $this->middleware('permission:create_rubro', ['only' => ['store']]);
        $this->middleware('permission:edit_rubro', ['only' => ['update']]);
        $this->middleware('permission:delete_rubro', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Rubro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newRubro = Rubro::create($request->json()->all());
        return response()->json($newRubro);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function show(Rubro $rubro)
    {
        return response()->json($rubro);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rubro $rubro)
    {
        $rubro->fill($request->json()->all())->save();
        return response()->json($rubro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubro $rubro)
    {
        if($rubro->subrubros()->count() !== 0){
            return response()->json(['error' => 'No se ha podido eliminar el rubro ' . $rubro->codigo . ' porque existen subrubros asociados'], 200);
        };
        $rubro->delete();
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
        $rubro = Rubro::where('codigo', $cod)->first();
        if($rubro === null){
            return response()->json('', 204);
        }
        else return response()->json($rubro);
    }
}
