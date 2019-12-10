<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('detalle')->nullable();
            $table->integer('reservado')->nullable();
            // id del pedido en mercado pago antes de pagar
            $table->string('preference_id')->nullable();
            //id del pedido pagado
            $table->string('pago_id')->nullable();
            $table->dateTime('fechaPago')->nullable();
            $table->dateTime('cambioEstado')->nullable();
            $table->string('rutaDePago')->nullable();
            $table->string('seguimientoEnvio')->nullable();
            $table->double('precio')->nullable();
            $table->boolean('produccion')->nullable();
            $table->smallInteger('terminado')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('flujoTrabajo_id')->nullable();
            $table->foreign('flujoTrabajo_id')->references('id')->on('flujo_trabajos');

            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados');

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
        Schema::dropIfExists('pedidos');
    }
}
