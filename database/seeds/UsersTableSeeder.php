<?php

use App\User;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'ADMIN';
        $user->apellido = 'ADMIN';
        $user->email = 'admin@admin.com';

        $user->password = Hash::make('12345678');
        $user->save();
        $rol = Role::where('name', 'ADMIN')->first()->get();
        DB::table('role_user')->insert(
            ['user_id' => $user->id, 'role_id' => 1]
        );
        // User::create([
        //     'nombre' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => '12345678',
        // ]);


    }
}
