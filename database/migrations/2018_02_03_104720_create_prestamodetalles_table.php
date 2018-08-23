<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamodetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prestamo_id')->unsigned();
            $table->foreign('prestamo_id')->references('id')->on('prestamos');
            $table->integer('tasacambio_id')->unsigned();
            $table->foreign('tasacambio_id')->references('id')->on('tasacambios');
            $table->integer('numcuota');
            $table->float('abonoprincipal')->nullable();
            $table->float('intereses');
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
        Schema::dropIfExists('prestamodetalles');
    }
}
