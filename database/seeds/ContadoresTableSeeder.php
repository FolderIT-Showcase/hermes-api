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
        $contadores[] = ['codigo' => 'FCA', 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['codigo' => 'FCB', 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['codigo' => 'FCC', 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['codigo' => 'PRA', 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['codigo' => 'PRB', 'punto_venta' => 1, 'ultimo_generado' => 0];
        $contadores[] = ['codigo' => 'PRC', 'punto_venta' => 1, 'ultimo_generado' => 0];

        foreach ($contadores as $contador) {
            $contadorDB = \App\Contador::whereHas('tipo_comprobante', function ($query) use ($contador) {
                $query->where('codigo', $contador['codigo']);
            })->first();
            if($contadorDB === null) {
                $contador['tipo_comprobante_id'] = \App\TipoComprobante::where('codigo', $contador['codigo'])->first()->id;
                unset($contador['codigo']);
                \App\Contador::insert($contador);
            }
        }
    }
}
