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
        $user = User::where('name', '=', 'admin')->first();
        if($user !== null){
            $user->detachRoles();
            $user->attachRole(Role::where('name', 'admin')->first());
        } else {
            $newUser = new User;
            $newUser->name = 'admin';
            $newUser->email = 'admin@folderit.net';
            $newUser->password = bcrypt('admin');
            $newUser->save();
            $newUser->attachRole(Role::where('name', 'admin')->first());
        }
    }
}
