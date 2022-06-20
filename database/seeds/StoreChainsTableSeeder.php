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
        
        for($i = 1; $i <= 8; $i++) {

                if ($i==1){
                    $container =  $i;
                }else{
                     $container =  2;    
                }
                DB::table('store_chains')->insert([
                    
                    'name' => 'テストチェーン ' . $i,
                    'pricetag_id' =>  $i,
                    'container_color_id' => $container
                ]);
        }

    }
}
