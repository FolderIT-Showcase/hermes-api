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
        $owner = role::firstOrNew(array('name' => 'dev'));
        $owner->name         = 'dev';
        $owner->display_name = 'Developer'; // optional
        $owner->description  = 'El usuario es un desarrollador de Hermes API'; // optional
        $owner->save();
    }
}