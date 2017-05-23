<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\ListaPrecioItem;
use App\ListaPrecios;
use Illuminate\Http\Request;
use Excel;

class ListaPreciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ListaPrecios::with('listaPrecioItem')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newLista = ListaPrecios::create($request->json()->all());
        return response()->json($newLista);
    }

    /**
     * Display the specified resource.
     *
     * @param ListaPrecios $listaprecio
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPrecios $listaprecio)
    {
        return response()->json($listaprecio);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ListaPrecios $listaprecio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPrecios $listaprecio)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $listaprecio->fill($data)->save();
        $listaprecio->load('listaPrecioItem');

        $viejosItems = $listaprecio['listaPrecioItem'];
        $nuevosItems = $data['lista_precio_item'];

        //Se borran los items que no vinieron en el request
        $itemsABorrar = $viejosItems->whereNotIn('id', array_column($nuevosItems, 'id'))->all();
        ListaPrecioItem::destroy(array_column($itemsABorrar, 'id'));

        //Se actualiza o se crea un item según si tiene seteado o no el id
        foreach ($nuevosItems as $item){
            $listaprecio->listaPrecioItem()->updateOrCreate(['id'=>(isset($item['id'])? $item['id'] : 0)], $item);
        }

        return response()->json($listaprecio->load('listaPrecioItem'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ListaPrecios $listaprecio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaPrecios $listaprecio)
    {
        if($listaprecio->listaPrecioItem()->count() !== 0){
            return response()->json(['error' => 'No se ha podido eliminar la lista de precios ' . $listaprecio->nombre . ' porque existen ítems asociados'], 200);
        };
        $listaprecio->delete();
        return response()->json('ok', 200);
    }

    /**
     * Import Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if ( $request->hasFile('file')) {
            $file = $request->file('file');
            $actualizarDescripcion = $request->get('actualizarDescripcion');
            $actualizarPrecioCosto = $request->get('actualizarPrecioCosto');
            $actualizarPrecioVenta = $request->get('actualizarPrecioVenta');
            $campoCodigoAUtilizar = $request->get('campoCodigoAUtilizar');

            $excel = Excel::load($file, function($reader) {
                    })->get();

            switch ($campoCodigoAUtilizar) {
                case 'codigo':
                    $campoCodigo = 'codigo';
                    break;
                case 'fabrica':
                    $campoCodigo = 'codigo_fabrica';
                    break;
                case 'auxiliar':
                    $campoCodigo = 'codigo_auxiliar';
                    break;
                default:
                    $campoCodigo = 'codigo';
            }

            foreach ($excel as $row) {
                $articulos = Articulo::where($campoCodigo, $row->codigo)->get();
                foreach ($articulos as $articulo) {
                    if ($actualizarDescripcion) {
                        $articulo->update(['nombre' => $row->nombre]);
                    }

                    if ($actualizarPrecioCosto) {
                        $articulo->update(['costo' => $row->precio_de_costo]);
                    }

                    $listasPreciosItems = ListaPrecioItem::where('articulo_id', $articulo->id)->get();
                    if ($actualizarPrecioCosto) {
                        foreach ($listasPreciosItems as $listaPrecioItem) {
                            if ($actualizarPrecioCosto) {
                                $listaPrecioItem->update(['precio_costo' => $articulo->costo]);
                            }

                            if ($actualizarPrecioVenta) {
                                $listaPrecios = ListaPrecios::where('id', $listaPrecioItem->lista_id)->first();
                                $listaPrecioItem->update(['precio_venta' => $articulo->costo * (1 + ($listaPrecios->porcentaje / 100))]);
                            }
                        }
                    }
                }
            }
            return response()->json('ok',200);
        } else {
            return response()->json(['error' => 'No se ha proporcionado un archivo']);
        }
    }

}
