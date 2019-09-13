<?php

use App\Item;
use App\TipoMateriaPrima;
use App\Receta;
use Illuminate\Database\Seeder;

class RecetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item3=Item::where('nombre','Remera')->first();
        $tipoMateriaPrima=TipoMateriaPrima::where('nombre','Telas')->first();

        $receta=new Receta();
        $receta->cantidad=10;
        $receta->item_id=$item3->id;
        $receta->tipoMateriaPrima_id=$tipoMateriaPrima->id;
        $receta->save();
    }
}
