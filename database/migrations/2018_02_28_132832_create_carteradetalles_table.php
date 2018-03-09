<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarteradetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carteradetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cartera_id')->unsigned();
            $table->foreign('cartera_id')->references('id')->on('carteras');
            $table->float('abono');
            $table->float('saldo'); 
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
        Schema::dropIfExists('carteradetalles');
    }
}
