<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriaPrimaSeleccionadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_prima_seleccionadas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->unsignedBigInteger('recetaHijo_id')->nullable();
            $table->foreign('recetaHijo_id')->references('id')->on('recetas');

            $table->unsignedBigInteger('recetaPadre_id')->nullable();
            $table->foreign('recetaPadre_id')->references('id')->on('recetas');

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
        Schema::dropIfExists('materia_prima_seleccionadas');
    }
}
