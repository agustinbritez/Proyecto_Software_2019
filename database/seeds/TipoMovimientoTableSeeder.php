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
        $tipoMov= new TipoMovimiento();
        $tipoMov->nombre='Ingreso';
        $tipoMov->detalle='Se compran o se obtienen por donaciones las materia primas';
        //se suman la materia prima
        $tipoMov->operacion=1;
        $tipoMov->save();
    }
}
