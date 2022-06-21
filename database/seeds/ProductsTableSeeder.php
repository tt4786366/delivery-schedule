<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j = 1;
        $lot = 10;
        $factory = 1;
        for($i = 1; $i <= 40; $i++) {


                DB::table('products')->insert([
                    
                    'name' => 'テスト商品 ' . $i,
                    'price' => $j*100,
                    'lot' => $lot,
                    'category_id' =>$j, 
                    'factory_id' => $factory,
                    'valid_from' => '2022/6/10',
                    'valid_until' => '2099/12/31'
                ]);
                $j++;
                if ($j>8){
                    $j=1;
                }
                if ($i>35){
                    $lot=1;
                    $factory=3;
                }elseif($i>20){
                    $lot=5;
                    $factory=2;
                }
                
                
                
        }        //
    }
}
