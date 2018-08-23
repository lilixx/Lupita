<?php

use Illuminate\Database\Seeder;

class AfiliacioncatalogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('afiliacioncatalogos')->insert(array(
          array('cantidad' => '1', 'valor' => '100'),
          array('cantidad' => '2', 'valor' => '50'),
          array('cantidad' => '1', 'valor' => '50'),
          array('cantidad' => '4', 'valor' => '25'),
          array('cantidad' => '1', 'valor' => '25'),
          array('cantidad' => '2', 'valor' => '25'),
          array('cantidad' => '3', 'valor' => '25'),

       ));
    }
}
