<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponenteImagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componente_imagen', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('componente_id')->nullable();
            $table->foreign('componente_id')->references('id')->on('componentes');
            
            $table->unsignedBigInteger('imagen_id')->nullable();
            $table->foreign('imagen_id')->references('id')->on('imagens');
            
          
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
        Schema::dropIfExists('componente_imagen');
    }
}
