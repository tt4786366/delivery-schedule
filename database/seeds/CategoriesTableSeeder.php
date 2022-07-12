<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


               DB::table('categories')->insert([
                    
                    'name' => '菊',
                ]);

               DB::table('categories')->insert([
                    
                    'name' => 'ユリ',
                ]);
               DB::table('categories')->insert([
                    
                    'name' => 'ほおずき',
                ]);
               DB::table('categories')->insert([
                    
                    'name' => '造花',
                ]);                
               DB::table('categories')->insert([
                    
                    'name' => '季節商品',
                ]);
               DB::table('categories')->insert([
                    
                    'name' => 'しばさかき',
                ]);
               DB::table('categories')->insert([
                    
                    'name' => '季節切り花',
                ]);
               DB::table('categories')->insert([
                    
                    'name' => '組花',
                ]);
               DB::table('categories')->insert([
                    
                    'name' => 'アレンジ',
                ]);                
    }
}
