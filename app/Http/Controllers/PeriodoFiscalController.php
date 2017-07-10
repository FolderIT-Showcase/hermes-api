<?php

namespace App\Http\Controllers;

use App\PeriodoFiscal;
use Illuminate\Http\Request;

class PeriodoFiscalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_periodoFiscal', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_periodoFiscal', ['only' => ['store']]);
        $this->middleware('permission:edit_periodoFiscal', ['only' => ['update']]);
        $this->middleware('permission:delete_periodoFiscal', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(PeriodoFiscal::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PeriodoFiscal  $periodoFiscal
     * @return \Illuminate\Http\Response
     */
    public function show(PeriodoFiscal $periodofiscal)
    {
        return response()->json($periodofiscal);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newPeriodoFiscal = PeriodoFiscal::create($request->json()->all());
        return response()->json($newPeriodoFiscal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PeriodoFiscal $periodoFiscal
     * @param  \Illuminate\Http\Request $request.
     * @return \Illuminate\Http\Response
     */
    public function update(PeriodoFiscal $periodofiscal, Request $request)
    {
        $periodofiscal->fill($request->json()->all())->save();
        return response()->json($periodofiscal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PeriodoFiscal $periodoFiscal.
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeriodoFiscal $periodofiscal)
    {
        $periodofiscal->delete();
        return response()->json('ok', 200);
    }
}