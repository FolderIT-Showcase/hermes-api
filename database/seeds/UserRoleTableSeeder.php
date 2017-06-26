<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', '=', 'dcampodonico@folderit.net')->first();

        $user->detachRole(Role::where('name', 'dev')->first());
        $user->attachRole(Role::where('name', 'dev')->first());
    }
}