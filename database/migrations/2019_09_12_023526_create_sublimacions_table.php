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
            $table->string('posX')->nullable();
            $table->string('posY')->nullable();
            $table->string('alto')->nullable();
            $table->string('ancho')->nullable();
            //cuando carga una imagen nueva que no es del sistema  el siguiente atributo estara cargado
            //cuando se procesa la imagen, el atributo nuevaImagen debera ser null y se debe referenciar a la imagen procesada
            $table->string('nuevaImagen')->nullable();
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
