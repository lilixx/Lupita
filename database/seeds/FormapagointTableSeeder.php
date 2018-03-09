<?php

use Illuminate\Database\Seeder;

class FormapagointTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formapagointeres')->insert(array(
           array('nombre' => 'acreditada a cuenta'),
           array('nombre' => 'pagado en cheque'),
       ));
    }
}
