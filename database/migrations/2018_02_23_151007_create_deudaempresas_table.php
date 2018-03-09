<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeudaempresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deudaempresas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id')->nullable()->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->integer('afiliaciondetalle_id')->nullable()->unsigned();
            $table->foreign('afiliaciondetalle_id')->references('id')->on('afiliaciondetalles');
            $table->integer('prestamodetalle_id')->nullable()->unsigned();
            $table->foreign('prestamodetalle_id')->references('id')->on('prestamodetalles');
            $table->integer('ahorrodetalle_id')->nullable()->unsigned();
            $table->foreign('ahorrodetalle_id')->references('id')->on('ahorrodetalles');
            $table->boolean('activo')->default(1);
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
        Schema::dropIfExists('deudaempresas');
    }
}
