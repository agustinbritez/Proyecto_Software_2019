<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSublimacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sublimacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('posX');
            $table->string('posY');
            $table->string('alto');
            $table->string('ancho');
            //cuando carga una imagen nueva que no es del sistema  el siguiente atributo estara cargado
            //cuando se procesa la imagen, el atributo nuevaImagen debera ser null y se debe referenciar a la imagen procesada
            $table->string('nuevaImagen');
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
        Schema::dropIfExists('sublimacions');
    }
}
