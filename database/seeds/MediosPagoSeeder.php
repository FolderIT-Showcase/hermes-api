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
        DB::table('medios_pago')->delete();

        $medio_pago = [];
        $medio_pago[] = [
            'id' => '1',
            'nombre' => 'Efectivo',
            'orden' => '1'
        ];
        $medio_pago[] = [
            'id' => '2',
            'nombre' => 'Cheque',
            'orden' => '2'
        ];
        $medio_pago[] = [
            'id' => '3',
            'nombre' => 'Tarjeta',
            'orden' => '3'
        ];
        $medio_pago[] = [
            'id' => '4',
            'nombre' => 'Depósito',
            'orden' => '4'
        ];
        $medio_pago[] = [
            'id' => '5',
            'nombre' => 'Redondeo',
            'orden' => '5'
        ];

        DB::table('medios_pago')->insert($medio_pago);

    }
}
