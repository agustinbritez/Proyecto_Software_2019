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
        $medida->id=1;
        $medida->detalle='CENTIMETROS';
        $medida->save();

        $medida= new Medida();
        $medida->nombre='METROS';
        $medida->id=2;
        $medida->detalle='METROS';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='MILIMETROS';
        $medida->id=3;
        $medida->detalle='MILIMETROS';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='GRAMOS';
        $medida->id=4;
        $medida->detalle='GRAMOS';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='KILO GRAMOS';
        $medida->id=5;
        $medida->detalle='KILO GRAMOS';
        $medida->save();

        $medida= new Medida();
        $medida->nombre='UNIDAD';
        $medida->id=6;
        $medida->detalle='UNIDAD';
        $medida->save();

        $medida= new Medida();
        $medida->nombre='CM CUADRADOS';
        $medida->id=7;
        $medida->detalle='CENTIMETROS CUADRADOS';
        $medida->save();
        
    }
}
