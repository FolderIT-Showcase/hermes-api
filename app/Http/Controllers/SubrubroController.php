<?php

namespace App\Http\Controllers;

use App\Subrubro;
use Illuminate\Http\Request;

class SubrubroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Subrubro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newSubrubro = Subrubro::create($request->json()->all());
        return response()->json($newSubrubro);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subrubro  $subrubro
     * @return \Illuminate\Http\Response
     */
    public function show(Subrubro $subrubro)
    {
        return response()->json($subrubro);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subrubro  $subrubro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subrubro $subrubro)
    {
        $subrubro->fill($request->json()->all())->save();
        return response()->json($subrubro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subrubro  $subrubro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subrubro $subrubro)
    {
        $subrubro->delete();
    }
}
