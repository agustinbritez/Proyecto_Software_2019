<?php

use App\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //dorso 
        

         $configuracion = new Configuracion();
         $configuracion->id = 1;
         $configuracion->nombre = 'MyG Sublimacion';
         $configuracion->telefono = '3758-42999999';
         $configuracion->contacto = '+54 9 3758 54-8057';
         $configuracion->email = 'MyGsublimacion@gmail.com';
         $configuracion->imagenPrincipal = 'logo2.jpeg';
         $configuracion->direccion_id = 1;
         $configuracion->seleccionado = 1;
         $configuracion->save();

    }
}
