<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationToMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            
            $table->unsignedBigInteger('tipoMovimiento_id');
            $table->foreign('tipoMovimiento_id')->references('id')->on('tipo_movimientos');

            $table->unsignedBigInteger('materiaPrima_id');
            $table->foreign('materiaPrima_id')->references('id')->on('materia_primas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos', function (Blueprint $table) {
            //
        });
    }
}
