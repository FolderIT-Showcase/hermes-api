<?php

use Illuminate\Database\Seeder;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $file_n = 'database\seeds\provincias.csv';
        $file = fopen($file_n, "r");

        $provincias = [];
        while ( ($data = fgetcsv($file, 200, ";")) !==FALSE) {

            $provincia = ['pais_id' => $data[0], 'id' => $data[1], 'nombre' => $data[2]];

            $provincias[] = $provincia;
        }
        \App\Provincia::insert($provincias);

        fclose($file);
    }
}
