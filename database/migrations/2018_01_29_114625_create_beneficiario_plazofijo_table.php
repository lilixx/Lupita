<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiarioPlazofijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiario_plazofijo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('beneficiario_id')->unsigned();
            $table->foreign('beneficiario_id')->references('id')->on('beneficiarios');
            $table->integer('plazofijo_id')->unsigned();
            $table->foreign('plazofijo_id')->references('id')->on('plazofijos');
            $table->float('porcentaje');
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
        Schema::dropIfExists('beneficiario_plazofijo');
    }
}
