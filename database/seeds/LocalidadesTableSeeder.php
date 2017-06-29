<?php

use Illuminate\Database\Seeder;

class LocalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(\App\Localidad::first() === null) {
            $file_n = 'database\seeds\localidades.csv';
            $file = fopen($file_n, "r");

            $localidades = [];
            $count = 0;
            while ( ($data = fgetcsv($file, 200, ";")) !==FALSE) {

                //Poner en mayúscula los nombres de las localidades
                //Ej: 25 DE MAYO -> 25 de Mayo; SANTA FE -> Santa Fe
                $nombre = mb_strtolower($data[2]);
                $excluir = array('a','de','del','el','en','la','las','lo','los','of','y');
                $words = explode(' ', $nombre);
                $isFirst = true;
                foreach($words as $key => $word) {

                    //Si la palabra es una de las excluídas y no es la primer palabra, no hay que ponerla en mayúscula
                    if(in_array($word, $excluir) && !$isFirst) {
                        continue;
                    }

                    $isFirst = false;

                    $words[$key] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');;
                }
                $nombre = implode(' ', $words);

                $localidad = ['provincia_id' => $data[0], 'cp' => $data[1], 'nombre' => $nombre];

                $localidades[] = $localidad;

                //Insertar de a mil elementos para evitar "General error: 1390 Prepared statement contains too many placeholders"
                if($count >= 1000){
                    $count = 0;
                    \App\Localidad::insert($localidades);
                    $localidades = array();
                }
                $count++;
            }
            \App\Localidad::insert($localidades);

            fclose($file);
        }
    }
}
