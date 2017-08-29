<?php

use Illuminate\Database\Seeder;

class MediosPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medios_pago = [];
        $medios_pago[] = ['id' => '1', 'nombre' => 'Efectivo','orden' => '1'];
        $medios_pago[] = ['id' => '2', 'nombre' => 'Cheque','orden' => '2'];
        $medios_pago[] = ['id' => '3', 'nombre' => 'Tarjeta','orden' => '3'];
        $medios_pago[] = ['id' => '4', 'nombre' => 'Depósito','orden' => '4'];
        $medios_pago[] = ['id' => '5', 'nombre' => 'Redondeo','orden' => '5'];

        foreach ($medios_pago as $medio_pago) {
            $medioPagoDB = \App\MedioPago::firstOrNew(['id' => $medio_pago['id']]);
            $medioPagoDB->nombre = $medio_pago['nombre'];
            $medioPagoDB->orden = $medio_pago['orden'];
            $medioPagoDB->save();
        }
    }
}
