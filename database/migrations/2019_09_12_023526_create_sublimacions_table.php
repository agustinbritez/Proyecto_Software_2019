<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSublimacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sublimacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('imagen_id');
            $table->foreign('imagen_id')->references('id')->on('imagens');
            
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
        Schema::dropIfExists('sublimacions');
    }
}
