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
        
        //producto base
        //telas 
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=4;
        $receta->modeloPadre_id=1;
        $receta->modeloHijo_id=null;
        $receta->save();

        
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=1;
        $receta->modeloPadre_id=1;
        $receta->modeloHijo_id=null;
        $receta->save();
        
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=2;
        $receta->modeloPadre_id=1;
        $receta->modeloHijo_id=null;
        $receta->save();
        
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=3;
        $receta->modeloPadre_id=1;
        $receta->modeloHijo_id=null;
        $receta->save();
       
        // Cierres

        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=5;
        $receta->modeloPadre_id=3;
        $receta->modeloHijo_id=null;
        $receta->save();

        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=6;
        $receta->modeloPadre_id=3;
        $receta->modeloHijo_id=null;
        $receta->save();

        //rellenos        
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=7;
        $receta->modeloPadre_id=2;
        $receta->modeloHijo_id=null;
        $receta->save();
             
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->materiaPrima_id=8;
        $receta->modeloPadre_id=2;
        $receta->modeloHijo_id=null;
        $receta->save();

        //*****************************************************productos bases */
        //almohada 30x30
               
        $receta=new Receta();
        $receta->cantidad=60;
        $receta->prioridad=0;
        $receta->modeloPadre_id=4;
        //telas
        $receta->modeloHijo_id=1;
        $receta->save();

               
        $receta=new Receta();
        $receta->cantidad=500;
        $receta->prioridad=0;
        $receta->modeloPadre_id=4;
        //rellenos
        $receta->modeloHijo_id=2;
        $receta->save();
               
        $receta=new Receta();
        $receta->cantidad=1;
        $receta->prioridad=0;
        $receta->modeloPadre_id=4;
        //cierres
        $receta->modeloHijo_id=3;
        $receta->save();

        //remersa S
               
        $receta=new Receta();
        $receta->cantidad=2500;
        $receta->prioridad=0;
        $receta->modeloPadre_id=7;
        //telas
        $receta->modeloHijo_id=1;
        $receta->save();

        //remersa XL
               
        $receta=new Receta();
        $receta->cantidad=3000;
        $receta->prioridad=0;
        $receta->modeloPadre_id=6;
        //telas
        $receta->modeloHijo_id=1;
        $receta->save();





    }
}
