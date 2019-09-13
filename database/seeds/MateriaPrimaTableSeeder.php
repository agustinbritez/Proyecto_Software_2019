<?php

use App\TipoMateriaPrima;
use App\MateriaPrima;
use App\Medida;
use Illuminate\Database\Seeder;

class MateriaPrimaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoMate= TipoMateriaPrima::where('nombre','Telas')->first();
        $medida= Medida::where('nombre','centimetros')->first();
        
        $materiaP= new MateriaPrima();
        $materiaP->nombre='TelaNegra';
        $materiaP->detalle='tela de tigre';
        $materiaP->cantidad=100;
        $materiaP->precioUnitario=10.0;
        $materiaP->color='Negro';
        $materiaP->tipoMateriaPrima_id=$tipoMate->id;
        $materiaP->medida_id=$medida->id;
        $materiaP->save();
    }
}
