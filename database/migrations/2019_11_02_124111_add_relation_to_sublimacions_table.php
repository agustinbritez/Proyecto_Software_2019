<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationToSublimacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sublimacions', function (Blueprint $table) {
            $table->unsignedBigInteger('imagen_id')->nullable();
            $table->foreign('imagen_id')->references('id')->on('imagens');

            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->unsignedBigInteger('componente_id')->nullable();
            $table->foreign('componente_id')->references('id')->on('componentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sublimacions', function (Blueprint $table) {
            //
        });
    }
}
