<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chainid=1;
        for($userid = 1; $userid <= 14; $userid++) {
                for($store = 1; $store <= 6; $store++){
                    DB::table('stores')->insert([
                        'name' => '店舗' . $userid . '-' . $store,
                        'chain_id' => $chainid,
	            	    'user_id' => $userid,
	            	    'valid_from' =>'2022/06/10'
	            	    
                    ]);
        		if ($chainid==8){
        			$chainid=1;
        		}else{
        			$chainid++;
        		}
            }
        }
        
            
    }
}
