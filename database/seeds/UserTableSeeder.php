<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrNew(array('username' => 'admin'));
        $user->email = 'admin@folderit.net';
        $user->username = 'admin';
        $user->name = 'Administrador';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
