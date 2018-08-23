<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlazofijosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plazofijos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('socio_id')->unsigned();
            $table->foreign('socio_id')->references('id')->on('socios');
            $table->integer('frecpagointere_id')->unsigned();
            $table->foreign('frecpagointere_id')->references('id')->on('frecpagointeres');
            $table->integer('formapagointere_id')->unsigned();
            $table->foreign('formapagointere_id')->references('id')->on('formapagointeres');
            $table->integer('plazofijotasa_id')->unsigned();
            $table->foreign('plazofijotasa_id')->references('id')->on('plazofijotasas');
            $table->boolean('debitoch')->default(0);
            $table->string('numdoc', 17);
            $table->date('creado');
            $table->date('vencimiento');
            $table->float('monto');
            $table->float('intereses');
            $table->float('ir');
            $table->integer('diaplazo');
            $table->boolean('pagadoantes')->default(0);
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
        Schema::dropIfExists('plazofijos');
    }
}
