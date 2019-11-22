<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePedidosRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidos_recetas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('detallePedido_id')->nullable();
            $table->foreign('detallePedido_id')->references('id')->on('detalle_pedidos');

            $table->unsignedBigInteger('receta_id')->nullable();
            $table->foreign('receta_id')->references('id')->on('recetas');
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
        Schema::dropIfExists('detalle_pedidos_recetas');
    }
}
