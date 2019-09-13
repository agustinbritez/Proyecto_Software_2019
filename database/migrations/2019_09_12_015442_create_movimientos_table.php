<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('precioUnitario');
            $table->integer('cantidad');
            $table->date('fecha');

            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            
            $table->unsignedBigInteger('tipoMovimiento_id');
            $table->foreign('tipoMovimiento_id')->references('id')->on('tipo_movimientos');

            $table->unsignedBigInteger('materiaPrima_id');
            $table->foreign('materiaPrima_id')->references('id')->on('materia_primas');

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
        Schema::dropIfExists('movimientos');
    }
}
