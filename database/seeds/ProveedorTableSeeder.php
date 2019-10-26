<?php

use App\Calle;
use App\Direccion;
use App\Localidad;
use App\Pais;
use App\Proveedor;
use App\Provincia;
use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $direccion=new Direccion();
        $direccion->numero='1234';
        $direccion->pais_id=Pais::where('nombre', 'ARGENTINA')->first->first()->get()->id;
        $direccion->provincia_id=Provincia::where('nombre', 'MISIONES')->first()->get()->id;
        $direccion->localidad_id=Localidad::where('nombre', 'POSADAS')->first()->get()->id;
        $direccion->calle_id=Calle::where('nombre', 'MAGALDI')->first()->get()->id;
        $direccion->save();

        $proveedor= new Proveedor();
        $proveedor->nombre='California';
        $proveedor->email='California@america.com';
        $proveedor->razonSocial='Sociedad Anonima';
        $proveedor->numeroDocumento='30-70152070-1';
        $proveedor->direccion_id=$direccion->id;
        $proveedor->save();
    }
}
