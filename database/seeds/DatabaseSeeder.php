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
        $this->call(PaisesTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(LocalidadesTableSeeder::class);
        $this->call(TipoComprobantesTableSeeder::class);
        $this->call(ContadoresTableSeeder::class);
        $this->call(ParametrosTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(TipoComprobantesCompraTableSeeder::class);
        $this->call(MediosPagoSeeder::class);
    }
}
