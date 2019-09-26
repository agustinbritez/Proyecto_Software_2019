<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationToMateriaPrimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materia_primas', function (Blueprint $table) {
            //unidad de medida
            $table->unsignedBigInteger('medida_id')->nullable();
            $table->foreign('medida_id')->references('id')->on('medidas');
            
            // $table->unsignedBigInteger('imagenPrincipal_id')->nullable();
            // $table->foreign('imagenPrincipal_id')->references('id')->on('imagenIndividuals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materia_primas', function (Blueprint $table) {
            //
        });
    }
}
