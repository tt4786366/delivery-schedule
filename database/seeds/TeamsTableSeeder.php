<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

               DB::table('teams')->insert([
                    
                    'name' => 'その他',
                    'section_id' => 1
                ]);   

 /*              DB::table('teams')->insert([
                    
                    'name' => 'A',
                    'section_id' => 1
                ]);

               DB::table('teams')->insert([
                    
                    'name' => 'B',
                    'section_id' => 1
                ]);
                
               DB::table('teams')->insert([
                    
                    'name' => 'C',
                    'section_id' => 1
                ]);

               DB::table('teams')->insert([
                    
                    'name' => 'D',
                    'section_id' => 1
                ]);   
                
                for($team=1; $team<=4; $team++){
                    DB::table('teams')->insert([
                        
                        'name' => $team,
                        'section_id' => 2
                    ]);                    
                }
   */             


    }
}
