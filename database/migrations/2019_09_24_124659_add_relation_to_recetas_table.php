<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationToRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recetas', function (Blueprint $table) {
            $table->unsignedBigInteger('modeloHijo_id')->nullable();
            $table->foreign('modeloHijo_id')->references('id')->on('modelos');
        
            $table->unsignedBigInteger('modeloPadre_id')->nullable();
            $table->foreign('modeloPadre_id')->references('id')->on('modelos');
            
            $table->unsignedBigInteger('materiaPrima_id')->nullable();
            $table->foreign('materiaPrima_id')->references('id')->on('materia_primas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recetas', function (Blueprint $table) {
            //
        });
    }
}
