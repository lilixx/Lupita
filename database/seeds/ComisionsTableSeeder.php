<?php

use Illuminate\Database\Seeder;

class ComisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comisions')->insert(array(
           array('nombre' => '1 a 6', 'valor' => '11'),
           array('nombre' => '7 a 8', 'valor' => '15'),
           array('nombre' => '9 a 12', 'valor' => '18'),
        ));
    }
}
