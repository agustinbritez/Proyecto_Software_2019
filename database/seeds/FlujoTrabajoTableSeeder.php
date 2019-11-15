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
        $flujo = new  FlujoTrabajo();
        $flujo->id = 1;
        $flujo->nombre = 'FLUJO PEDIDOS';
        $flujo->save();
        $flujo = new  FlujoTrabajo();
        $flujo->id = 2;
        $flujo->nombre = 'FLUJO PRODUCCION GENERAL';
        $flujo->save();
    }
}
