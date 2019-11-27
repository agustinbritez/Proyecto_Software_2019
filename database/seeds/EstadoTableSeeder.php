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
        $estado = new Estado();
        $estado->nombre = 'PRODUCCION';
        $estado->save();
        $estado = new Estado();
        $estado->nombre = 'VERIFICACION';
        $estado->save();
        $estado = new Estado();
        $estado->nombre = 'ESPERA DE PAGO';
        $estado->save();
        $estado = new Estado();
        $estado->nombre = 'CARRITO';
        $estado->save();

        // $estado=new Estado();
        // $estado->nombre='Final';
        // $estado->save();
    }
}
