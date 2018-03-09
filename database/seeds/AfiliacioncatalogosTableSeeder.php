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
          array('nombre' => '2', 'valor' => '50'),
          array('nombre' => '4', 'valor' => '25'),
       ));
    }
}
