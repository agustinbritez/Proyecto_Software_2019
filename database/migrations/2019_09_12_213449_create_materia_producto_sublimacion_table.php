<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriaProductoSublimacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_producto_sublimacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos');
            
            $table->unsignedBigInteger('sublimacion_id')->nullable();
            $table->foreign('sublimacion_id')->references('id')->on('sublimacions');
            
          
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
        Schema::dropIfExists('materia_producto_sublimacion');
    }
}
