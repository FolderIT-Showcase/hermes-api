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
        // los devuelvo ordenados "cronologicamente" del mas reciente al mas antiguo
        return response()->json(PeriodoFiscal::orderBy('mes', 'DESC')
                                    ->orderBy('anio', 'DESC')
                                    ->get()
        );
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
     * Display the specified resources.
     *
     * @param @boo
     * @return \Illuminate\Http\Response
     */
    public function showActive($boo)
    {
        // los devuelvo ordenados "cronologicamente" del mas reciente al mas antiguo
        return response()->json(PeriodoFiscal::where('abierto', $boo)
            ->orderBy('mes', 'DESC')
            ->orderBy('anio', 'DESC')
            ->get()
        );
    }

    /**
     * Display the specified resources.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showByAll(Request $request)
    {
        // filtrar por estos parametros
        $anio = $request->input('anio', '0');
        $abierto = $request->input('abierto', '-1');

        $per = PeriodoFiscal::orderBy('id', 'ASC');

        if($anio != '0'){
            $per = $per->where('anio', '=', $anio);
        }
        if($abierto != '-1'){
            $per = $per->where('abierto', '=', $abierto);
        }

        $result = $per->get();

        if($result === null){
            return response()->json('', 204);
        }
        else return response()->json($result);
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