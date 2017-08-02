<?php

namespace App\Http\Controllers;

use App\CuentaBancaria;
use Illuminate\Http\Request;

class CuentaBancariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_cuenta_bancaria', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_cuenta_bancaria', ['only' => ['store']]);
        $this->middleware('permission:edit_cuenta_bancaria', ['only' => ['update']]);
        $this->middleware('permission:delete_cuenta_bancaria', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(CuentaBancaria::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newCuentaBancaria = CuentaBancaria::create($request->json()->all());
        return response()->json($newCuentaBancaria);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function show(CuentaBancaria $cuentaBancaria)
    {
        return response()->json($cuentaBancaria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CuentaBancaria $cuentaBancaria)
    {
        $cuentaBancaria->fill($request->json()->all())->save();
        return response()->json($cuentaBancaria);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(CuentaBancaria $cuentaBancaria)
    {
        // TODO chequear Integrity constraint violation
        $cuentaBancaria->delete();
        return response()->json('ok', 200);
    }
}
