<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call([StoresTableSeeder::class]);
        // $this->call(UsersTableSeeder::class);
        //$this->call(CategoriesTableSeeder::class);
        //$this->call(FactoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        }
}
