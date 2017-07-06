<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_proveedor', ['only' => ['index', 'show', 'showByCode']]);
        $this->middleware('permission:create_proveedor', ['only' => ['store']]);
        $this->middleware('permission:edit_proveedor', ['only' => ['update']]);
        $this->middleware('permission:delete_proveedor', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Proveedor::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        return response()->json($proveedor);
    }

    /**
     * Display the specified resource.
     *
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByCode($cod)
    {
        $proveedores = Proveedor::where('codigo', $cod)->first();
        if($proveedores === null){
            return response()->json('', 204);
        }
        else return response()->json($proveedores);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newProveedor = Proveedor::create($request->json()->all());
        return response()->json($newProveedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Proveedor $proveedor
     * @param  \Illuminate\Http\Request $request.
     * @return \Illuminate\Http\Response
     */
    public function update(Proveedor $proveedor, Request $request)
    {
        $proveedor->fill($request->json()->all())->save();
        return response()->json($proveedor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Proveedor $proveedor.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return response()->json('ok', 200);
    }

}