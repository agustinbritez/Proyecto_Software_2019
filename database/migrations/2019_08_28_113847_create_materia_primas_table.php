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
            $table->string('nombre')->nullable()->unique();
            $table->string('detalle')->nullable();
            $table->integer('cantidad')->nullable();
            $table->double('precioUnitario')->nullable();
            $table->string('color')->nullable();
            $table->string('imagenPrincipal')->nullable();
            $table->softDeletes();
           
            
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
