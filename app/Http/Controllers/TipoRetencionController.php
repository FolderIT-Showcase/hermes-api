<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoRetencion;

class TipoRetencionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_tipoRetencion', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_tipoRetencion', ['only' => ['store']]);
        $this->middleware('permission:edit_tipoRetencion', ['only' => ['update']]);
        $this->middleware('permission:delete_tipoRetencion', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TipoRetencion::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoRetencion  $tiporetencion
     * @return \Illuminate\Http\Response
     */
    public function show(TipoRetencion $tiporetencion)
    {
        return response()->json($tiporetencion);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newTipoRetencion = TipoRetencion::create($request->json()->all());
        return response()->json($newTipoRetencion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\TipoRetencion  $tiporetencion
     * @param  \Illuminate\Http\Request $request.
     * @return \Illuminate\Http\Response
     */
    public function update(TipoRetencion $tiporetencion, Request $request)
    {
        $tiporetencion->fill($request->json()->all())->save();
        return response()->json($tiporetencion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TipoRetencion  $tiporetencion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoRetencion $tiporetencion)
    {
        $tiporetencion->delete();
        return response()->json('ok', 200);
    }
}