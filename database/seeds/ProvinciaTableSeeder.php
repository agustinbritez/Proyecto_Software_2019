<?php

use App\Provincia;
use Illuminate\Database\Seeder;

class ProvinciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provincia=new Provincia();
        $provincia->nombre='MISIONES';
        $provincia->save();
    }
}
