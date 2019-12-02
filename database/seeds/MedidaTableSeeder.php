<?php

use App\Medida;
use Illuminate\Database\Seeder;

class MedidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medida= new Medida();
        $medida->nombre='CENTIMETROS';
        $medida->detalle='CENTIMETROS';
        $medida->save();

        $medida= new Medida();
        $medida->nombre='METROS';
        $medida->detalle='METROS';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='MILIMETROS';
        $medida->detalle='MILIMETROS';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='GRAMOS';
        $medida->detalle='GRAMOS';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='KILO GRAMOS';
        $medida->detalle='KILO GRAMOS';
        $medida->save();

        $medida= new Medida();
        $medida->nombre='UNIDAD';
        $medida->detalle='UNIDAD';
        $medida->save();
        
    }
}
