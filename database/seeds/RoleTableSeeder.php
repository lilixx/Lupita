<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('roles')->insert(array(
         array('nombre' => 'Admin'),
         array('nombre' => 'Supervisor'),
         array('nombre' => 'Usuario'),
         array('nombre' => 'Root'),
      ));
    }
}
