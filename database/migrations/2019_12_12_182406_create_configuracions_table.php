<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            //whatsapp
            $table->string('contacto')->nullable();
            $table->string('imagenPrincipal')->nullable();
            $table->boolean('seleccionado')->nullable();
            
            $table->unsignedBigInteger('direccion_id')->nullable();
            $table->foreign('direccion_id')->references('id')->on('direccions');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracions');
    }
}
