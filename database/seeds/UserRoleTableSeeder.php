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
        if($user !== null){
            $user->detachRole(Role::where('name', 'dev')->first());
            $user->attachRole(Role::where('name', 'dev')->first());
        } else {
            $newUser = new User;
            $newUser->name = 'Daniel Campodonico';
            $newUser->email = 'dcampodonico@folderit.net';
            $newUser->password = bcrypt('123456');
            $newUser->attachRole(Role::where('name', 'dev')->first());
            $newUser->save();
        }
    }
}