<?php

use Illuminate\Database\Seeder;

class FrecuenciapagointTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frecpagointeres')->insert(array(
           array('nombre' => 'mensual'),
           array('nombre' => 'semestral'),
           array('nombre' => 'anual'),
        ));
    }
}
