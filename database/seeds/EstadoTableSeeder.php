<?php

use App\Estado;
use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado=new Estado();
        $estado->nombre='Inicio';
        $estado->save();
        
        $estado=new Estado();
        $estado->nombre='Final';
        $estado->save();
    }
}
