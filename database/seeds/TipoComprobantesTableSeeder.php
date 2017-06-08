<?php

use Illuminate\Database\Seeder;

class TipoComprobantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoComprobantes = [];
        $tipoComprobantes[] = ['codigo' => 'FCA', 'nombre' => 'Factura A'];
        $tipoComprobantes[] = ['codigo' => 'FCB', 'nombre' => 'Factura B'];
        $tipoComprobantes[] = ['codigo' => 'FCC', 'nombre' => 'Factura C'];
        $tipoComprobantes[] = ['codigo' => 'PRA', 'nombre' => 'Presupuesto A'];
        $tipoComprobantes[] = ['codigo' => 'PRB', 'nombre' => 'Presupuesto B'];
        $tipoComprobantes[] = ['codigo' => 'PRC', 'nombre' => 'Presupuesto C'];

        foreach ($tipoComprobantes as $tipoComprobante) {
            $tipoComprobanteDB = \App\TipoComprobante::firstOrNew(['codigo' => $tipoComprobante['codigo']]);
            $tipoComprobanteDB->nombre = $tipoComprobante['nombre'];
            $tipoComprobanteDB->save();
        }
    }
}
