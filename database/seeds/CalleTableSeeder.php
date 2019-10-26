<?php

use App\Calle;
use Illuminate\Database\Seeder;

class CalleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calle=new Calle();
        $calle->nombre='MAGALDI';
        $calle->numero='132';
        $calle->save();
    }
}
