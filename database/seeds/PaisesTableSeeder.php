<?php

use Illuminate\Database\Seeder;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_n = 'database\seeds\paises.csv';
        $file = fopen($file_n, "r");

        $paises = [];
        while ( ($data = fgetcsv($file, 200, ";")) !==FALSE) {

            $pais = ['id' => $data[0], 'nombre' => $data[1]];

            $paises[] = $pais;
        }

        \App\Pais::insert($paises);
        fclose($file);
    }
}
