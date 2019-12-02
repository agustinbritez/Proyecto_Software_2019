<?php

use Illuminate\Database\Seeder;
use App\Rol;
use Caffeinated\Shinobi\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = new Role();
        $rol->name = 'admin';
        $rol->slug = 'admin';
        $rol->special = 'all-access';
        $rol->save();

        $rol = new Role();
        $rol->name = 'cliente';
        $rol->slug = 'cliente';
        $rol->save();

        $rol = new Role();
        $rol->name = 'empleado';
        $rol->slug = 'empleado';
        $rol->save();

        $rol = new Role();
        $rol->name = 'auditor';
        $rol->slug = 'auditor';
        $rol->save();

        $rol = new Role();
        $rol->name = 'gerente';
        $rol->slug = 'gerente';
        $rol->save();
    }
}
