<?php


use App\Localidad;
use Illuminate\Database\Seeder;

class LocalidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localidad=new Localidad();
        $localidad->nombre='POSADAS';
        $localidad->codigoPostal='3300';
        $localidad->save();
    }
}
