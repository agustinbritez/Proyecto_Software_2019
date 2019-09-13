<?php

use App\FlujoTrabajo;
use Illuminate\Database\Seeder;

class FlujoTrabajoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flujo=new  FlujoTrabajo();
        $flujo->nombre='Produccion Remera';
        
        $flujo->save();
    }
}
