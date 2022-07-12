<?php

use Illuminate\Database\Seeder;

class StoreChainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                DB::table('store_chains')->insert([
                    
                    'name' => 'サニー',
                    'pricetag_id' => 1,
                    'container_color_id' => 1
                ]);
                DB::table('store_chains')->insert([
                    
                    'name' => 'エフコープ',
                    'pricetag_id' => 2,
                    'container_color_id' => 2
                ]);
                DB::table('store_chains')->insert([
                    
                    'name' => 'マミーズ',
                    'pricetag_id' => 3,
                    'container_color_id' => 2
                ]);
                DB::table('store_chains')->insert([
                    
                    'name' => 'イーマート',
                    'pricetag_id' => 4,
                    'container_color_id' => 2
                ]);        
                DB::table('store_chains')->insert([
                    
                    'name' => '明治屋食品',
                    'pricetag_id' => 5,
                    'container_color_id' => 2
                ]);
                DB::table('store_chains')->insert([
                    
                    'name' => 'エルショップ',
                    'pricetag_id' => 6,
                    'container_color_id' => 2
                ]);
                DB::table('store_chains')->insert([
                    
                    'name' => 'サトー',
                    'pricetag_id' => 7,
                    'container_color_id' => 2
                ]);
                DB::table('store_chains')->insert([
                    
                    'name' => 'グリーンズ協和',
                    'pricetag_id' => 8,
                    'container_color_id' => 2
                ]);                
                DB::table('store_chains')->insert([
                    
                    'name' => 'フレッシュフルーツメイト',
                    'pricetag_id' => 9,
                    'container_color_id' => 2
                ]);                





    }
}
