<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Domicilio;
use App\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use JasperPHP\JasperPHP as JasperPHP;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Cliente::with('domicilios')->get());
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $newCliente = (new Cliente())->fill($data);
        $domicilios = $data['domicilios'];

        $newCliente->save();
        foreach ($domicilios as $domicilio){
            $newCliente->domicilios()->create($domicilio);
        }

        return response()->json($newCliente->load('domicilios'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        return response()->json($cliente->load('domicilios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Cliente $cliente)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $cliente->fill($data)->save();
        $cliente->load('domicilios');

        $viejosDomicilios = $cliente['domicilios'];
        $nuevosDomicilios = $data['domicilios'];

        //Se borran los domicilios que no vinieron en el request
        $domiciliosABorrar = $viejosDomicilios->whereNotIn('id', array_column($nuevosDomicilios, 'id'))->all();
        Domicilio::destroy(array_column($domiciliosABorrar, 'id'));

        //Se actualiza o se crea un domicilio segun si tiene seteado o no el id
        foreach ($nuevosDomicilios as $domicilio){
            $cliente->domicilios()->updateOrCreate(['id'=>(isset($domicilio['id'])? $domicilio['id'] : 0)], $domicilio);
        }

        return response()->json($cliente->load('domicilios'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json('ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $cod
     * @return \Illuminate\Http\Response
     */
    public function showByCode($cod)
    {
        $clientes = Cliente::where('codigo', $cod)->get();
        if($clientes === null){
            return response()->json('', 204);
        }
        else return response()->json($clientes);
    }

    /**
     * Display the specified resource.
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function showByName($name)
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $name . '%')->get();
        if($clientes === null){
            return response()->json('', 204);
        }
        else return response()->json($clientes);
    }

    /**
     * Display the specified resource.
     *
     * @param $busqueda
     * @return \Illuminate\Http\Response
     */
    public function showByAll($busqueda)
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $busqueda . '%')
            ->orWhere('codigo', 'like', '%' . $busqueda . '%')
            ->orWhere('cuit', 'like', '%' . $busqueda . '%')
            ->orwhereHas('domicilios', function ($q) use ($busqueda) {
                $q->where('direccion', 'like', '%' . $busqueda . '%');
            })
            ->with('domicilios')
            ->limit(10)
            ->get();
        if($clientes === null){
            return response()->json('', 204);
        }
        else return response()->json($clientes);
    }

    /**
     * Generate report
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @internal param $vendedor
     * @internal param $zona
     * @internal param $provincia
     * @internal param $localidad
     * @internal param $activos
     */
    public function report(Request $request)
    {
        $vendedor = $request->input('vendedor', '0');
        $zona = $request->input('zona', '0');
        $provincia = $request->input('provincia', '0');
        $localidad = $request->input('localidad', '0');
        $activos = $request->input('activos', '0');

        $jasper = new JasperPHP;
        $IMAGE_DIR = base_path() . "/resources/assets/img/";
        $VENDEDOR = '"' . $vendedor . '"';
        $ZONA = '"' . $zona . '"';
        $PROVINCIA = '"' . $provincia . '"';
        $LOCALIDAD = '"' . $localidad . '"';
        $ACTIVOS = '"' . $activos . '"';
        $EMPRESA_NOMBRE = '"' . Parametro::where('nombre', 'EMPRESA_NOMBRE')->first()->valor . '"';
        $EMPRESA_DOMICILIO = '"' . Parametro::where('nombre', 'EMPRESA_DOMICILIO')->first()->valor . '"';
        $EMPRESA_CUIT = '"' . Parametro::where('nombre', 'EMPRESA_CUIT')->first()->valor . '"';
        $EMPRESA_TIPO_RESP = '"' . Parametro::where('nombre', 'EMPRESA_TIPO_RESP')->first()->valor . '"';
        $output_path = base_path() . '/resources/assets/reports/tmp/clientes' . time();

        $jasper->process(
            base_path() . '/resources/assets/reports/clientes.jasper',
            $output_path,
            array("pdf"),
            array("IMAGE_DIR" => $IMAGE_DIR,
                  "VENDEDOR" => $VENDEDOR,
                  "ZONA" => $ZONA,
                  "PROVINCIA" => $PROVINCIA,
                  "LOCALIDAD" => $LOCALIDAD,
                  "ACTIVOS" => $ACTIVOS,
                  "EMPRESA_NOMBRE" => $EMPRESA_NOMBRE,
                  "EMPRESA_DIRECCION" => $EMPRESA_DOMICILIO,
                  "EMPRESA_CUIT" => $EMPRESA_CUIT,
                  "EMPRESA_TIPO_RESP" => $EMPRESA_TIPO_RESP,
            ),
            Config::get('database.connections.mysql')
        )->execute();

        return response()->download($output_path . '.pdf', 'reporte_clientes.pdf')->deleteFileAfterSend(true);
    }
}
