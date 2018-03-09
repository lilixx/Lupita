<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ComisionsTableSeeder::class);
        $this->call(AfiliacioncatalogosTableSeeder::class);
        $this->call(CooperativaTableSeeder::class);
        $this->call(TasacambioTableSeeder::class);
        $this->call(ConceptoTableSeeder::class);
        $this->call(FrecuenciapagointTableSeeder::class);
        $this->call(FormapagointTableSeeder::class);  
    }
}
