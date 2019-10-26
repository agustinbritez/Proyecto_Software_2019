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
        $rol->name= 'ADMIN';
        $rol->slug='admin';
        $rol->special='all-access';
        $rol->save();
    
    }
}
