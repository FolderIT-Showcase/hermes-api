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

        foreach ($tipoComprobantesCompra as $tipoComprobante) {
            $tipoComprobanteDB = \App\TipoComprobanteCompra::firstOrNew(['codigo' => $tipoComprobante['codigo']]);
            $tipoComprobanteDB->nombre = $tipoComprobante['nombre'];
            $tipoComprobanteDB->save();
        }
    }
}