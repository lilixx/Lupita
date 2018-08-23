<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'name' => 'lila',
           'email' => 'lila2390@gmail.com',
           'password' => bcrypt('lila777'),
           'name' => 'yn1v',
           'email' => 'neville@taygon.com',
           'password' => bcrypt('pinguino'),
       ]);
    }
}
