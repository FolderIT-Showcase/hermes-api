<?php

use Illuminate\Database\Seeder;

class ContadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contadores = [];
        $contadores[] = ['tipo_comprobante_id' => 1, 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['tipo_comprobante_id' => 2, 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['tipo_comprobante_id' => 3, 'punto_venta' => 1, 'ultimo_generado' => 0];
        \App\Contador::insert($contadores);
    }
}
