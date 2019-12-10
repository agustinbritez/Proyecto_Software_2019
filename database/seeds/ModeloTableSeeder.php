<?php

use App\Modelo;
use Illuminate\Database\Seeder;

class ModeloTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelo = new Modelo();
        $modelo->id = 1;
        $modelo->nombre = 'TELAS';
        $modelo->base = 1;
        $modelo->precioUnitario = 0.20;
        $modelo->imagenPrincipal = 'telascolores.jpg';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 7;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();

        $modelo = new Modelo();
        $modelo->id = 2;
        $modelo->nombre = 'RELLENOS';
        $modelo->base = 1;
        $modelo->precioUnitario = 0.30;
        $modelo->imagenPrincipal = 'rellenos.jpg';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 4;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();

        $modelo = new Modelo();
        $modelo->id = 3;
        $modelo->nombre = 'CIERRES';
        $modelo->base = 1;
        $modelo->precioUnitario = 5.0;
        $modelo->imagenPrincipal = 'cierrescolores.jpg';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 6;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();
        //******************************************************************************modelos NO BASE */
        $modelo = new Modelo();
        $modelo->id = 4;
        $modelo->nombre = 'ALMOHADA 30 X 30 CM';
        $modelo->base = 0;
        $modelo->precioUnitario = 250.0;
        $modelo->imagenPrincipal = 'almohada.png';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 6;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();

        $modelo = new Modelo();

        $modelo->id = 5;
        $modelo->nombre = 'ALMOHADA 40 X 40 CM';
        $modelo->base = 0;
        $modelo->precioUnitario = 250.0;
        $modelo->imagenPrincipal = 'almohada.png';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 6;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();

        $modelo = new Modelo();
        $modelo->id = 6;
        $modelo->nombre = 'REMERA XL';
        $modelo->base = 0;
        $modelo->precioUnitario = 500.0;
        $modelo->imagenPrincipal = 'remerafrontal.png';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 6;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();

        $modelo = new Modelo();
        $modelo->id = 7;
        $modelo->nombre = 'REMERA S';
        $modelo->base = 0;
        $modelo->precioUnitario = 250.0;
        $modelo->imagenPrincipal = 'remerafrontal.png';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 6;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();

        $modelo = new Modelo();
        $modelo->id = 8;
        $modelo->nombre = 'REMERA NEGRA S';
        $modelo->base = 0;
        $modelo->precioUnitario = 450.0;
        $modelo->imagenPrincipal = 'remerafrontalNegra.png';
        //si no se movio el seeder de medida el 1 es CENTIMETROS
        $modelo->medida_id = 6;
        $modelo->flujoTrabajo_id = 2;
        $modelo->save();
    }
}
