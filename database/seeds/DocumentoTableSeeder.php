<?php

use App\Documento;
use Illuminate\Database\Seeder;

class DocumentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documento=new Documento();
        $documento->nombre='CUIT';
        $documento->detalle='Clave Unica de Identificación Tributaria';
        $documento->save();
        
        $documento=new Documento();
        $documento->nombre='DNI';
        $documento->detalle='Documento Nacional de Identidad';
        $documento->save();
    }
}
