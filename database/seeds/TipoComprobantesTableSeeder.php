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
        $tipoComprobantes[] = ['codigo' => 'FCA', 'nombre' => 'A'];
        $tipoComprobantes[] = ['codigo' => 'FCB', 'nombre' => 'B'];
        $tipoComprobantes[] = ['codigo' => 'FCC', 'nombre' => 'C'];
        $tipoComprobantes[] = ['codigo' => 'PRA', 'nombre' => 'A'];
        $tipoComprobantes[] = ['codigo' => 'PRB', 'nombre' => 'B'];
        $tipoComprobantes[] = ['codigo' => 'PRC', 'nombre' => 'C'];

        foreach ($tipoComprobantes as $tipoComprobante) {
            $tipoComprobanteDB = \App\TipoComprobante::firstOrNew(['codigo' => $tipoComprobante['codigo']]);
            $tipoComprobanteDB->nombre = $tipoComprobante['nombre'];
            $tipoComprobanteDB->save();
        }
    }
}
