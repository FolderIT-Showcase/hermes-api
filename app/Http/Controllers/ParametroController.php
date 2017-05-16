<?php

namespace App\Http\Controllers;

use App\Parametro;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametros = Parametro::all();
        foreach($parametros as &$parametro) {
            switch ($parametro->data_type) {
                case 'STR':
                    $parametro->valor = (string)$parametro->valor;
                    break;
                case 'BOOL':
                    $parametro->valor = $parametro->valor === 'S' ? true : false;
                    break;
                case 'NUM':
                    $parametro->valor = floatval($parametro->valor);
                    break;
                default:
                    $parametro->valor = (string)$parametro->valor;
            }
        }
        return response()->json($parametros);
    }

}
