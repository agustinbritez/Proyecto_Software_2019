<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extracciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('materiaPrima_id')->unsigned();
            $table->foreign('materiaPrima_id')->references('id')->on('materia_primas');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extracciones');
    }
}
