<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAhorrodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ahorrodetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ahorro_id')->unsigned();
            $table->foreign('ahorro_id')->references('id')->on('ahorros');
            $table->integer('concepto_id')->unsigned();
            $table->foreign('concepto_id')->references('id')->on('conceptos');
            $table->string('rock_ck', 30);
            $table->float('debitos')->nullable();
            $table->float('creditos')->nullable();
            $table->float('saldofinal');
            $table->date('fecha');
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
        Schema::dropIfExists('ahorrodetalles');
    }
}
