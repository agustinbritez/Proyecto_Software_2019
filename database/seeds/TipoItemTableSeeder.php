<?php

use App\FlujoTrabajo;
use App\TipoItem;
use Illuminate\Database\Seeder;

class TipoItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flujo=FlujoTrabajo::where('nombre','Produccion Remera')->first();

        $tipoItem=new TipoItem();
        $tipoItem->nombre='Remera Nueva';
        $tipoItem->detalle='La remera nueva debe pasar por un proceso mas largo que la remeras hechas';
        
        $tipoItem->flujoTrabajo_id=$flujo->id;
        $tipoItem->save();
    }
}
