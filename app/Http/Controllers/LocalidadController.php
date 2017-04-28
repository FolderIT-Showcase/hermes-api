<?php

namespace App\Http\Controllers;

use App\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Localidad $localidad
     * @return \Illuminate\Http\Response
     */
    public function show(Localidad $localidad)
    {
        return response()->json($localidad);
    }
}
