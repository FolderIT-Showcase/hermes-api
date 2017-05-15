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
        \App\TipoComprobante::insert($tipoComprobantes);
    }
}
