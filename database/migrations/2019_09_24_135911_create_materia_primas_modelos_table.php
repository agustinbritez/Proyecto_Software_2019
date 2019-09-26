<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriaPrimasModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_primas_modelos', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('materiaPrima_id')->nullable();
            $table->foreign('materiaPrima_id')->references('id')->on('materia_primas');
            
            $table->unsignedBigInteger('modelo_id')->nullable();
            $table->foreign('modelo_id')->references('id')->on('modelos');
            
            
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
        Schema::dropIfExists('materia_primas_modelos');
    }
}
