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
        $user=new User();
        $user->nombre='admin';
        $user->apellido='admin';
        $user->email='admin@admin';

        $user->password=Hash::make('12345678');
        $rol=Role::where('name','ADMIN')->first()->get();
        $user->roles()->sync($rol);
        $user->save();

        // User::create([
        //     'nombre' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => '12345678',
        // ]);

        
    }
}
