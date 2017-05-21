<?php

namespace App\Http\Controllers;

use App\TipoCategoriaCliente;

class TipoCategoriaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TipoCategoriaCliente::all());
    }

}
