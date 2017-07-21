<?php

namespace App\Http\Controllers;

use App\TipoComprobanteCompra;

class TipoComprobanteCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TipoComprobanteCompra::all());
    }
}