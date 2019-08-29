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
        Schema::create('extraccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('materia_prima_id');
            $table->timestamps();
            $table->foreign('materia_prima_id')->references('id')->on('materia_primas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extraccions');
    }
}
