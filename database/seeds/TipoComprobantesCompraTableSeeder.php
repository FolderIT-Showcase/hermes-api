<?php

use Illuminate\Database\Seeder;

class TipoComprobantesCompraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoComprobantesCompra = [];
        $tipoComprobantesCompra[] = ['codigo' => 'FCA', 'nombre' => 'Factura A'];
        $tipoComprobantesCompra[] = ['codigo' => 'FCB', 'nombre' => 'Factura B'];
        $tipoComprobantesCompra[] = ['codigo' => 'FCC', 'nombre' => 'Factura C'];
        $tipoComprobantesCompra[] = ['codigo' => 'NCA', 'nombre' => 'Nota de Crédito A'];
        $tipoComprobantesCompra[] = ['codigo' => 'NCB', 'nombre' => 'Nota de Crédito B'];
        $tipoComprobantesCompra[] = ['codigo' => 'NCC', 'nombre' => 'Nota de Crédito C'];
        $tipoComprobantesCompra[] = ['codigo' => 'NDA', 'nombre' => 'Nota de Débito A'];
        $tipoComprobantesCompra[] = ['codigo' => 'NDB', 'nombre' => 'Nota de Débito B'];
        $tipoComprobantesCompra[] = ['codigo' => 'NDC', 'nombre' => 'Nota de Débito C'];
        $tipoComprobantesCompra[] = ['codigo' => 'REC', 'nombre' => 'Recibo'];

        foreach ($tipoComprobantesCompra as $tipoComprobante) {
            $tipoComprobanteDB = \App\TipoComprobanteCompra::firstOrNew(['codigo' => $tipoComprobante['codigo']]);
            $tipoComprobanteDB->nombre = $tipoComprobante['nombre'];
            $tipoComprobanteDB->save();
        }
    }
}