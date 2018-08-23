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
           array('nombre' => 'mensual', 'numero' => '12'),
           array('nombre' => 'semestral', 'numero' => '2'),
           array('nombre' => 'anual', 'numero' => '1'),
           array('nombre' => 'trimestral', 'numero' => '4'),
        ));
    }
}
