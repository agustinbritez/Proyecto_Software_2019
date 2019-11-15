<?php

use App\User;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(TipoMovimientoTableSeeder::class);
        $this->call(DocumentoTableSeeder::class);
        $this->call(EstadoTableSeeder::class);
        $this->call(PaisTableSeeder::class);
        $this->call(ProvinciaTableSeeder::class);
        $this->call(LocalidadTableSeeder::class);
        $this->call(CalleTableSeeder::class);
        $this->call(MedidaTableSeeder::class);
        $this->call(FlujoTrabajoTableSeeder::class);
        $this->call(TransicionTableSeeder::class);


        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProveedorTableSeeder::class);
    }
}
