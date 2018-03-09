<?php

use Illuminate\Database\Seeder;

class CooperativaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cooperativas')->insert(array(
           array('nombre' => 'MARIA ELSA IXCHEL CROSS VOGL', 'cargo' => 'PRESIDENTA', 'sexo' => 'F'),
           array('nombre' => 'GENARO HERNANDEZ', 'cargo' => 'VICEPRESIDENTE', 'sexo' => 'M'),
           array('nombre' => 'GUSTAVO ALFREDO WOO PINEDA', 'cargo' => 'SECRETARIO', 'sexo' => 'M'),
           array('nombre' => 'VICTOR MANUEL LEZAMA CALDERON', 'cargo' => 'TESORERO', 'sexo' => 'M'),
           array('nombre' => 'YELBA MARTINEZ GUZMAN', 'cargo' => 'VOCAL', 'sexo' => 'F'),
           array('nombre' => 'MIGUEL ENESTO DEL VALLE IBARRA', 'cargo' => 'COORDINADOR', 'sexo' => 'M'),
           array('nombre' => 'MYRIAM DEL SOCORRO DEL CASTILLO HURTADO', 'cargo' => 'VOCAL', 'sexo' => 'F'),
           array('nombre' => 'PEDRO JOAQUIN BRAVO AGUILAR', 'cargo' => 'SECRETARIO', 'sexo' => 'M'),
           array('nombre' => 'Yadira Ramírez Castillo', 'cargo' => 'REGISTRO Y CONTROL', 'sexo' => 'F'),
        ));
    }
}
