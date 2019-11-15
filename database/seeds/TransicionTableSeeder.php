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
        $inicio = Estado::where('nombre', 'INICIADO')->first();
        $final = Estado::where('nombre', 'FINALIZADO')->first();
        $produccion = Estado::where('nombre', 'PRODUCCION')->first();
        $verificacion = Estado::where('nombre', 'VERIFICACION')->first();
        $espera = Estado::where('nombre', 'ESPERA DE PAGO')->first();

        $flujoPedidos = FlujoTrabajo::where('FLUJO PEDIDOS')->first();
        $flujoProducto = FlujoTrabajo::where('FLUJO PRODUCCION GENERAL')->first();
        // Creando el fujo de trabajo del pedido
        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoPedidos->id;
        $trans->estadoInicio_id = null;
        $trans->estadoFin_id = $espera->id;
        $trans->save();

        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoPedidos->id;
        $trans->estadoInicio_id = $espera->id;
        $trans->estadoFin_id = $verificacion->id;
        $trans->save();

        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoPedidos->id;
        $trans->estadoInicio_id = $verificacion->id;
        $trans->estadoFin_id = $produccion->id;
        $trans->save();

        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoPedidos->id;
        $trans->estadoInicio_id = $produccion->id;
        $trans->estadoFin_id = $final->id;
        $trans->save();

        //creando flujo de trabajo del producto
        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoProducto->id;
        $trans->estadoInicio_id = null;
        $trans->estadoFin_id = $inicio->id;
        $trans->save();

        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoProducto->id;
        $trans->estadoInicio_id = $inicio->id;
        $trans->estadoFin_id = $produccion->id;
        $trans->save();

        $trans = new Transicion();
        $trans->flujoTrabajo_id = $flujoProducto->id;
        $trans->estadoInicio_id = $produccion->id;
        $trans->estadoFin_id = $final->id;
        $trans->save();
    }
}
