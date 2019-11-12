<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transicions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('flujoTrabajo_id')->nullable();
            $table->foreign('flujoTrabajo_id')->references('id')->on('flujo_trabajos');

            $table->unsignedBigInteger('estadoInicio_id')->nullable();
            $table->foreign('estadoInicio_id')->references('id')->on('estados');

            $table->unsignedBigInteger('estadoFin_id')->nullable();
            $table->foreign('estadoFin_id')->references('id')->on('estados');

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
        Schema::dropIfExists('transicions');
    }
}
