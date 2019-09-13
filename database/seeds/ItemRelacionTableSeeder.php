<?php

use App\ItemRelacion;
use Illuminate\Database\Seeder;
use App\Item;
class ItemRelacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1=Item::where('nombre','Tela Sapo')->first();
        $item2=Item::where('nombre','Tela Tigre')->first();
        $item3=Item::where('nombre','Remera')->first();

        $itemRelacion= new ItemRelacion();
        $itemRelacion->itemHijo_id=$item3->id;
        $itemRelacion->itemPadre_id=$item2->id;
        $itemRelacion->save();
        
        $itemRelacion= new ItemRelacion();
        $itemRelacion->itemHijo_id=$item3->id;
        $itemRelacion->itemPadre_id=$item1->id;
        $itemRelacion->save();
    }
}
