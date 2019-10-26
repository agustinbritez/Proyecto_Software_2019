<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationDireccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direccions', function (Blueprint $table) {
            $table->unsignedBigInteger('calle_id')->nullable();
            $table->foreign('calle_id')->references('id')->on('calles');
          
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->foreign('localidad_id')->references('id')->on('localidads');
            
            $table->unsignedBigInteger('provincia_id')->nullable();
            $table->foreign('provincia_id')->references('id')->on('provincias');
            
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->foreign('pais_id')->references('id')->on('pais');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direccions', function (Blueprint $table) {
            //
        });
    }
}
