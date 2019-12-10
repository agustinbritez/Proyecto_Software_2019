<?php
use App\Componente;
use Illuminate\Database\Seeder;

class ComponenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //remera S
        //fronta 
        $componente = new Componente();
        $componente->id = 1;
        $componente->nombre = 'Frontal';
        $componente->imagenPrincipal = 'remeraFrontal.png';
        $componente->modelo_id = 7;
        $componente->save();
        //dorso 
        $componente = new Componente();
        $componente->id = 2;
        $componente->nombre = 'Dorso';
        $componente->imagenPrincipal = 'remeraDorso.png';
        $componente->modelo_id = 7;
        $componente->save();
        
        //remera XL
        //fronta 
        $componente = new Componente();
        $componente->id = 3;
        $componente->nombre = 'Frontal';
        $componente->imagenPrincipal = 'remeraFrontal.png';
        $componente->modelo_id = 6;
        $componente->save();
        //dorso 
        $componente = new Componente();
        $componente->id = 4;
        $componente->nombre = 'Dorso';
        $componente->imagenPrincipal = 'remeraDorso.png';
        $componente->modelo_id = 6;
        $componente->save();
        
        //almohada 30 x 30
        //fronta 
        $componente = new Componente();
        $componente->id = 5;
        $componente->nombre = 'Frontal';
        $componente->imagenPrincipal = 'almohadaFrontal.png';
        $componente->modelo_id = 4;
        $componente->save();
        //dorso 
        $componente = new Componente();
        $componente->id = 6;
        $componente->nombre = 'Dorso';
        $componente->imagenPrincipal = 'almohadaFrontal.png';
        $componente->modelo_id = 4;
        $componente->save();

    }
}
