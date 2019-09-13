<?php

use App\Estado;
use App\Transicion;
use App\FlujoTrabajo;
use Illuminate\Database\Seeder;

class TransicionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flujo=FlujoTrabajo::where('nombre','Produccion Remera')->first();
        $inicio=Estado::where('nombre','Inicio')->first();
        $final=Estado::where('nombre','Final')->first();

        $trans=new Transicion();
        $trans->flujoTrabajo_id=$flujo->id;
        $trans->estadoInicio_id=$inicio->id;
        $trans->estadoFin_id=$final->id;
        $trans->save();
    }
}
