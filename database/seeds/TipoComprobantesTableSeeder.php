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
        $tipoComprobantes[] = ['codigo' => 'PRX', 'nombre' => 'Presupuesto'];
        $tipoComprobantes[] = ['codigo' => 'NCA', 'nombre' => 'Nota de Crédito A'];
        $tipoComprobantes[] = ['codigo' => 'NCB', 'nombre' => 'Nota de Crédito B'];
        $tipoComprobantes[] = ['codigo' => 'NCC', 'nombre' => 'Nota de Crédito C'];
        $tipoComprobantes[] = ['codigo' => 'NDA', 'nombre' => 'Nota de Débito A'];
        $tipoComprobantes[] = ['codigo' => 'NDB', 'nombre' => 'Nota de Débito B'];
        $tipoComprobantes[] = ['codigo' => 'NDC', 'nombre' => 'Nota de Débito C'];
        $tipoComprobantes[] = ['codigo' => 'REC', 'nombre' => 'Recibo'];

        foreach ($tipoComprobantes as $tipoComprobante) {
            $tipoComprobanteDB = \App\TipoComprobante::firstOrNew(['codigo' => $tipoComprobante['codigo']]);
            $tipoComprobanteDB->nombre = $tipoComprobante['nombre'];
            $tipoComprobanteDB->save();
        }
    }
}
