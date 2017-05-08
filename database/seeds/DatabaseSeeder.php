<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(PaisesTableSeeder::class);
//        $this->call(ProvinciasTableSeeder::class);
//        $this->call(LocalidadesTableSeeder::class);
//        $this->call(TipoComprobantesTableSeeder::class);
        $this->call(ContadoresTableSeeder::class);
    }
}
