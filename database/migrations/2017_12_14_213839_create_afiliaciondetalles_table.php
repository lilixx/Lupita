<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfiliaciondetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afiliaciondetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('afiliacion_id')->unsigned();
            $table->foreign('afiliacion_id')->references('id')->on('afiliacions');
            $table->integer('num_deduccion');
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
        Schema::dropIfExists('afiliaciondetalles');
    }
}
