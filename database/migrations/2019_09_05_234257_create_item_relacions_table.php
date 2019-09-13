<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemRelacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_relacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('modificable');
            $table->integer('prioridad');
            $table->integer('cantidad');

            $table->unsignedBigInteger('itemHijo_id')->nullable();
            $table->foreign('itemHijo_id')->references('id')->on('items');
        
            $table->unsignedBigInteger('itemPadre_id')->nullable();
            $table->foreign('itemPadre_id')->references('id')->on('items');
        
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
        Schema::dropIfExists('item_relacions');
    }
}
