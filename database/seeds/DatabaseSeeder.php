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
        $this->call(UserTableSeeder::class);
        $this->call(ComisionsTableSeeder::class);
        $this->call(AfiliacioncatalogosTableSeeder::class);
        $this->call(CooperativaTableSeeder::class);
        $this->call(TasacambioTableSeeder::class);
        $this->call(ConceptoTableSeeder::class);
        $this->call(FrecuenciapagointTableSeeder::class);
        $this->call(FormapagointTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(AhorrotasaTableSeeder::class);
        $this->call(PlazofijotasaTableSeeder::class);
    }
}
