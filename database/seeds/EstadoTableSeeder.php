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
        $estado = new Estado();
        $estado->nombre = 'INICIADO';
        $estado->save();
        $estado = new Estado();
        $estado->nombre = 'FINALIZADO';
        $estado->save();

        // $estado=new Estado();
        // $estado->nombre='Final';
        // $estado->save();
    }
}
