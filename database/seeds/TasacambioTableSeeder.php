<?php

use Illuminate\Database\Seeder;

class TasacambioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasacambios')->insert(array(
           array('valor' => '30.55'),
        ));
    }
}
