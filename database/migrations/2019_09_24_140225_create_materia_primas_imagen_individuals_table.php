<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriaPrimasImagenIndividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_primas_imagen_individuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('imagenIndividual_id')->nullable();
            $table->foreign('imagenIndividual_id')->references('id')->on('imagen_individuals');
            
            $table->unsignedBigInteger('materiaPrima_id')->nullable();
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
        Schema::dropIfExists('materia_primas_imagen_individuals');
    }
}
