<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('socio_id')->unsigned();
            $table->foreign('socio_id')->references('id')->on('socios');
            $table->integer('fiador_id')->nullable()->unsigned();
            $table->foreign('fiador_id')->references('id')->on('fiadors');
            $table->integer('comision_id')->nullable()->unsigned();
            $table->foreign('comision_id')->references('id')->on('comisions');
            $table->string('parentescof', 50)->nullable();
            $table->float('intereses')->nullable();
            $table->float('monto');
            $table->integer('plazo')->nullable()->unsigned();
            $table->float('cuota');
            $table->string('num_cheque', 40)->nullable();
            $table->integer('cantcuotas')->unsigned();
            $table->date('fechainicio');
            $table->date('vencimiento')->nullable();
            $table->boolean('mensual')->default(0);
            $table->integer('pmensual')->nullable();
            $table->boolean('resumen')->default(0);
            $table->boolean('pagado')->default(0);
            $table->boolean('pausa')->default(0);
            $table->boolean('anticipo')->default(0);
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
        Schema::dropIfExists('prestamos');
    }
}
