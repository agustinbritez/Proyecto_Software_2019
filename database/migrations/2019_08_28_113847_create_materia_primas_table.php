<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriaPrimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_primas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('detalle');
            $table->integer('cantidad');
            $table->double('precioUnitario');
            $table->string('color');
            
            $table->unsignedBigInteger('tipoMateriaPrima_id');
            $table->foreign('tipoMateriaPrima_id')->references('id')->on('tipo_materia_primas');
            //unidad de medida
            $table->unsignedBigInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('medidas');
            
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
        Schema::create('materia_primas', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('nombre');
            $table->dropColumn('detalle');
            
        });
    }
}
