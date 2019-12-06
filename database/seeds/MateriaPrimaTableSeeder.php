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
        $medida = Medida::where('nombre', 'CENTIMETROS')->first();
        $unidad = Medida::where('nombre', 'UNIDAD')->first();
        $kilo = Medida::where('nombre', 'KILO GRAMOS')->first();

        $materiaP = new MateriaPrima();
        $materiaP->id = 1;
        $materiaP->nombre = 'TELA NEGRA';
        $materiaP->detalle = 'tela de nilo';
        $materiaP->cantidad = 1000000;
        $materiaP->stockMinimo = 10000;
        $materiaP->precioUnitario = 0.20;
        $materiaP->medida_id = $medida->id;
        $materiaP->imagenPrincipal = 'telanegra.jpg';
        $materiaP->save();

        $materiaP = new MateriaPrima();
        $materiaP->id = 2;
        $materiaP->nombre = 'TELA ROJA';
        $materiaP->detalle = 'tela de nilo';
        $materiaP->cantidad = 1000000;
        $materiaP->stockMinimo = 10000;
        $materiaP->precioUnitario = 0.20;
        $materiaP->medida_id = $medida->id;
        $materiaP->imagenPrincipal = 'telaroja.jpg';
        $materiaP->save();

        $materiaP = new MateriaPrima();
        $materiaP->id = 3;
        $materiaP->nombre = 'TELA VERDE';
        $materiaP->detalle = 'tela de nilo';
        $materiaP->cantidad = 1000000;
        $materiaP->stockMinimo = 10000;
        $materiaP->precioUnitario = 0.20;
        $materiaP->medida_id = $medida->id;
        $materiaP->imagenPrincipal = 'telaverde.jpg';
        $materiaP->save();

        $materiaP = new MateriaPrima();
        $materiaP->id = 4;
        $materiaP->nombre = 'TELA BLANCA';
        $materiaP->detalle = 'tela de nilo';
        $materiaP->cantidad = 1000000;
        $materiaP->stockMinimo = 10000;
        $materiaP->precioUnitario = 0.20;
        $materiaP->medida_id = $medida->id;
        $materiaP->imagenPrincipal = 'telablanca.jpg';
        $materiaP->save();

        $materiaP = new MateriaPrima();
        $materiaP->id = 5;
        $materiaP->nombre = 'CIERRE AZUL';
        $materiaP->detalle = '';
        $materiaP->cantidad = 100;
        $materiaP->stockMinimo = 50;
        $materiaP->precioUnitario = 2;
        $materiaP->medida_id = $unidad->id;
        $materiaP->imagenPrincipal = 'cierreazul.jpg';
        $materiaP->save();


        $materiaP = new MateriaPrima();
        $materiaP->id = 6;
        $materiaP->nombre = 'CIERRE ROJO';
        $materiaP->detalle = '';
        $materiaP->cantidad = 100;
        $materiaP->stockMinimo = 50;
        $materiaP->precioUnitario = 2;
        $materiaP->medida_id = $unidad->id;
        $materiaP->imagenPrincipal = 'cierrerojo.jpg';
        $materiaP->save();

        $materiaP = new MateriaPrima();
        $materiaP->id = 7;
        $materiaP->nombre = 'PLUMAS';
        $materiaP->detalle = '';
        $materiaP->cantidad = 100;
        $materiaP->stockMinimo = 50;
        $materiaP->precioUnitario = 2;
        $materiaP->medida_id = $kilo->id;
        $materiaP->imagenPrincipal = 'plumas.jpg';
        $materiaP->save();

        $materiaP = new MateriaPrima();
        $materiaP->id = 8;
        $materiaP->nombre = 'ALGODON';
        $materiaP->detalle = '';
        $materiaP->cantidad = 100;
        $materiaP->stockMinimo = 50;
        $materiaP->precioUnitario = 2;
        $materiaP->medida_id = $kilo->id;
        $materiaP->imagenPrincipal = 'algodon.jpg';
        $materiaP->save();
    }
}
