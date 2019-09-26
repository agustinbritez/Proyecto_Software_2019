<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationComponentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('componentes', function (Blueprint $table) {
            $table->unsignedBigInteger('modelo_id')->nullable();
            $table->foreign('modelo_id')->references('id')->on('modelos');
        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('componentes', function (Blueprint $table) {
            //
        });
    }
}
