<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponenteSublimacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componente_sublimacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('componente_id')->nullable();
            $table->foreign('componente_id')->references('id')->on('componentes');
            
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
        Schema::dropIfExists('componente_sublimacion');
    }
}
