<?php

use Illuminate\Database\Seeder;

class FactoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 3; $i++) {

               DB::table('factories')->insert([
                    
                    'name' => 'テスト工場 ' . $i,
                ]);
        }         
    }
}
