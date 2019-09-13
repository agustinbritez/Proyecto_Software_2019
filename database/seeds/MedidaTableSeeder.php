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
        $medida->nombre='centimetros';
        $medida->detalle='centimetros';
        $medida->save();

        $medida= new Medida();
        $medida->nombre='metros';
        $medida->detalle='metros';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='milimetros';
        $medida->detalle='milimetros';
        $medida->save();
        
        $medida= new Medida();
        $medida->nombre='gramos';
        $medida->detalle='gramos';
        $medida->save();
        
    }
}
