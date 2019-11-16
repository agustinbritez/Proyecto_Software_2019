<?php

use App\Calle;
use App\Direccion;
use App\Documento;
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

        $direccion = new Direccion();
        $direccion->numero = '1234';
        $direccion->pais_id = (Pais::where('nombre', 'ARGENTINA')->first())->id;
        $direccion->provincia_id = (Provincia::where('nombre', 'MISIONES')->first())->id;
        $direccion->localidad_id = (Localidad::where('nombre', 'POSADAS')->first())->id;
        $direccion->calle_id = (Calle::where('nombre', 'MAGALDI')->first())->id;
        $direccion->save();

        $documento = Documento::where('nombre', 'CUIT')->first();

        $proveedor = new Proveedor();
        $proveedor->nombre = 'California';
        $proveedor->email = 'California@america.com';
        $proveedor->razonSocial = 'Sociedad Anonima';
        if ($documento != null) {

            $proveedor->documento_id = $documento->id;
        }
        $proveedor->numeroDocumento = '30-70152070-1';
        $proveedor->direccion_id = $direccion->id;
        $proveedor->save();
    }
}
