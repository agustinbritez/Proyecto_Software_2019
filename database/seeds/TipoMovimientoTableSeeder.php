<?php

use App\TipoMovimiento;
use Illuminate\Database\Seeder;

class TipoMovimientoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoMov = new TipoMovimiento();
        $tipoMov->nombre = 'INGRESO';
        $tipoMov->detalle = 'Se compran o se obtienen por donaciones las materia primas';
        //se suman la materia prima
        $tipoMov->operacion = 1;
        $tipoMov->save();
        $tipoMov = new TipoMovimiento();
        $tipoMov->nombre = 'EGRESO';
        $tipoMov->detalle = 'Materia Primas en salen de la empresa';
        //se resta la materia prima
        $tipoMov->operacion = 0;
        $tipoMov->save();
        $tipoMov = new TipoMovimiento();
        $tipoMov->nombre = 'VENTA';
        $tipoMov->detalle = 'Materia Primas que salen por venta';
        //se resta la materia prima
        $tipoMov->operacion = 0;
        $tipoMov->save();
    }
}
