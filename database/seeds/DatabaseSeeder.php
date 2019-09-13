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

        $this->call(MedidaTableSeeder::class);
        $this->call(ProveedorTableSeeder::class);
        $this->call(TipoMateriaPrimaTableSeeder::class);
        $this->call(MateriaPrimaTableSeeder::class);
        $this->call(TipoMovimientoTableSeeder::class);
        $this->call(MovimientoTableSeeder::class);

        $this->call(EstadoTableSeeder::class);
        $this->call(FlujoTrabajoTableSeeder::class);
        $this->call(TransicionTableSeeder::class);
        
        $this->call(TipoItemTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(RecetaTableSeeder::class);
        
        
        //$this->call(ItemRelacionTableSeeder::class);
        //$this->call(Role::class);
        // $this->call(UsersTableSeeder::class);
       
    }
}
