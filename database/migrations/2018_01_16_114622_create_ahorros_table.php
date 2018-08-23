<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAhorrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ahorros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('socio_id')->unsigned();
            $table->foreign('socio_id')->references('id')->on('socios');
            $table->integer('beneficiario_id')->unsigned();
            $table->foreign('beneficiario_id')->references('id')->on('beneficiarios');
            $table->integer('ahorrotasa_id')->unsigned();
            $table->foreign('ahorrotasa_id')->references('id')->on('ahorrotasas');
            $table->date('fechainicio');
            $table->float('depositoinicial')->nullable();
            $table->boolean('dolar')->default(1);
            $table->float('dia15')->nullable();
            $table->float('dia30')->nullable();
            $table->boolean('pausada')->default(0);
            $table->boolean('activo')->default(1);
            $table->boolean('especial')->default(0);
            $table->boolean('plazofijo')->default(0);
            $table->boolean('retencion')->default(1);
            $table->longText('comentario')->nullable();
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
        Schema::dropIfExists('ahorros');
    }
}
