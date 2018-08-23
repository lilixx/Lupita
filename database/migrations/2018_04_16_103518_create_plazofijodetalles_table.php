<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlazofijodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plazofijodetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plazofijo_id')->unsigned();
            $table->foreign('plazofijo_id')->references('id')->on('plazofijos');
            $table->integer('numero')->unsigned();
            $table->float('intereses')->nullable();
            $table->float('ir');
            $table->float('total');
            $table->string('rock_ck', 30)->nullable();
            $table->boolean('penalidad')->default(0);
            $table->float('valorpenalidad')->nullable();
            $table->boolean('pagado')->default(0);
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
        Schema::dropIfExists('plazofijodetalles');
    }
}
