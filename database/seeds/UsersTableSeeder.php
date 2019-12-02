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
        $user->assignRoles('ADMIN');

        $user = new User();
        $user->name = 'empleado';
        $user->apellido = 'empleado';
        $user->email = 'empleado@empleado.com';

        $user->password = Hash::make('12345678');
        $user->save();
        $user->assignRoles('empleado');

        $user = new User();
        $user->name = 'gerente';
        $user->apellido = 'gerente';
        $user->email = 'gerente@gerente.com';

        $user->password = Hash::make('12345678');
        $user->save();
        $user->assignRoles('gerente');


        $user = new User();
        $user->name = 'auditor';
        $user->apellido = 'auditor';
        $user->email = 'auditor@auditor.com';

        $user->password = Hash::make('12345678');
        $user->save();
        $user->assignRoles('auditor');


        // $rol = Role::where('name', 'ADMIN')->first()->get();
        // DB::table('role_user')->insert(
        //     ['user_id' => $user->id, 'role_id' => 1]
        // );
        // User::create([
        //     'nombre' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => '12345678',
        // ]);


    }
}
