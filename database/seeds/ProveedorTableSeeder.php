<?php

use App\Proveedor;
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
        $proveedor= new Proveedor();
        $proveedor->nombre='California';
        $proveedor->email='California@america.com';
        $proveedor->razonSocial='Sociedad Anonima';
        $proveedor->save();
    }
}
