<?php

namespace App\Http\Controllers;

use App\MedioPago;

class MedioPagoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(MedioPago::orderBy('orden', 'ASC')->get());
    }
}
