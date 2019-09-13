<?php

use App\Estado;
use App\Item;
use App\Medida;
use App\TipoItem;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tipoItem=TipoItem::where('nombre','Remera Nueva')->first();


        $item3= new Item();
        $item3->nombre='Remera';
        $item3->detalle=' ';
        $item3->tipoItem_id=$tipoItem->id;
        
        $item3->save();
       
        

    }
}
