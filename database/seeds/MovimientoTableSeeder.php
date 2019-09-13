<?php

use App\MateriaPrima;
use App\Movimiento;
use App\Proveedor;
use App\TipoMovimiento;
use Illuminate\Database\Seeder;

class MovimientoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoM=TipoMovimiento::where('nombre','Ingreso')->first();
        $mp=MateriaPrima::where('nombre','TelaNegra')->first();
        $c=Proveedor::where('nombre','California')->first();

        $movimiento= new Movimiento();
        $movimiento->precioUnitario=10.0;
        $movimiento->cantidad=100;
        $movimiento->fecha=new DateTime('now');
        $movimiento->tipoMovimiento_id=$tipoM->id;
        $movimiento->materiaPrima_id=$mp->id;
        $movimiento->proveedor_id=$c->id;
        $movimiento->save();
    }
}
