<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->nombre='admin';
        $user->apellido='admin';
        $user->email='admin@admin';
        $user->password=crypt('12345678');
        $user->save();

        // User::create([
        //     'nombre' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => '12345678',
        // ]);

        
    }
}
