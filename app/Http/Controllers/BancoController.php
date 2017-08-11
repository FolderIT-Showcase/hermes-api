<?php

namespace App\Http\Controllers;

use App\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_banco', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_banco', ['only' => ['store']]);
        $this->middleware('permission:edit_banco', ['only' => ['update']]);
        $this->middleware('permission:delete_banco', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Banco::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newBanco = Banco::create($request->json()->all());
        return response()->json($newBanco);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function show(Banco $banco)
    {
        return response()->json($banco);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banco $banco)
    {
        $banco->fill($request->json()->all())->save();
        return response()->json($banco);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banco $banco)
    {
        // TODO chequear Integrity constraint violation
        $banco->delete();
        return response()->json('ok', 200);
    }
}
