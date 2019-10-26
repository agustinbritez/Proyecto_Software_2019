<?php

use App\Pais;
use Illuminate\Database\Seeder;

class PaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pais=new Pais();
        $pais->nombre='ARGENTINA';
        $pais->save();
    }
}
