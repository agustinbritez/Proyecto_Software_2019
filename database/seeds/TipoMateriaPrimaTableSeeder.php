<?php

use Illuminate\Database\Seeder;
use App\TipoMateriaPrima;
class TipoMateriaPrimaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoMate= new TipoMateriaPrima();
        $tipoMate->nombre='Telas';
        $tipoMate->detalle='telas';
        $tipoMate->save();
    }
}
