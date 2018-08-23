<?php

use Illuminate\Database\Seeder;

class ConceptoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conceptos')->insert(array(
           array('nombre' => 'Deposito'),
           array('nombre' => 'Retiro'),
           array('nombre' => 'Intereses'),
           array('nombre' => 'Retencion IR'),
           array('nombre' => 'N/D'),
           array('nombre' => 'N/C Int CDPF'),
        ));
    }
}
