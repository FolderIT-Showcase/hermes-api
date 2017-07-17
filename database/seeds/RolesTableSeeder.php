<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = role::firstOrNew(array('name' => 'admin'));
        $owner->name         = 'admin';
        $owner->display_name = 'Administrador'; // optional
        $owner->description  = 'El usuario es un administrador de Hermes API'; // optional
        $owner->save();
    }
}