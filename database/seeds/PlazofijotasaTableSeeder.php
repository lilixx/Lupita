<?php

use Illuminate\Database\Seeder;

class PlazofijotasaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('plazofijotasas')->insert(array(
         array('valor' => '7'),
      ));
    }
}
