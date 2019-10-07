<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::table('proveedors', function (Blueprint $table) {
            $table->unsignedBigInteger('documento_id')->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos');

            $table->unsignedBigInteger('direccion_id')->nullable();
            $table->foreign('direccion_id')->references('id')->on('direccions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proveedors', function (Blueprint $table) {
            //
        });
    }
}
