<?php

use Illuminate\Database\Seeder;

class AhorrotasaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ahorrotasas')->insert(array(
         array('valor' => '5'),
      ));
    }
}
