<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id')->nullable()->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->date('fecha_nac');
            $table->char('sexo', 4);
            $table->string('lugar_nac', 60)->nullable();
            $table->string('nacionalidad', 40)->nullable();
            $table->string('estado_civil', 30)->nullable();
            $table->string('nombre_conyuge', 80)->nullable();
            $table->integer('num_hijos')->nullable();
            $table->string('num_cedula', 16)->nullable();
            $table->string('num_licencia', 20)->nullable();
            $table->string('num_inss', 20)->nullable();
            $table->string('antiguedad', 10)->nullable();
            $table->float('otrosingresos', 10)->nullable();
            $table->string('origenoting', 50)->nullable();
            $table->longText('direccion_casa')->nullable();
            $table->string('telf_casa', 40)->nullable();
            $table->string('telf_trabajo', 40)->nullable();
            $table->string('municipio', 40)->nullable();
            $table->string('ciudad', 40)->nullable();
            $table->string('departamento', 40)->nullable();
            $table->string('cargo', 60)->nullable();
            $table->float('sueldo')->nullable();
            $table->longText('comentario')->nullable();
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
        Schema::dropIfExists('socios');
    }
}
