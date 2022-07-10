<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 /*                   DB::table('users')->insert([
                        'name' => '管理者',
                        'password' => Hash::make('admin'),
                        'email' => 'admin@admin.com',
	            	    'team_id' => 1,
	            	    'authorization' => 1
                    ]);
                    
 */
        for($userid = 2; $userid <= 15; $userid++) {
                    if($userid % 4 ==1 ){
                        $team = 1;
                    } elseif($userid % 4 ==2 ){
                        $team = 2;
                    }elseif($userid % 4 ==3 ){
                        $team = 3;
                    }elseif($userid % 4 ==0 ){
                        $team = 4;
                    }
 
                    DB::table('users')->insert([
                        'name' => '配送担当' . $userid,
                        'password' => Hash::make('test' . $userid),
                        'email' => 'test'. $userid . '@test.com',
	            	    'team_id' => $team,
	            	    'authorization' => 2
                    ]);
            


 

        }     
    }
}
