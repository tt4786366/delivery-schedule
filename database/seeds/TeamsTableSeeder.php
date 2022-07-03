<?php

use Illuminate\Database\Seeder;

class TeamssTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()


               DB::table('teams')->insert([
                    
                    'name' => 'A',
                    'section_id' => 1
                ]);

               DB::table('teams')->insert([
                    
                    'name' => 'B'
                    'section_id' => 1
                ]);
                
               DB::table('teams')->insert([
                    
                    'name' => 'C'
                    'section_id' => 1
                ]);

               DB::table('teams')->insert([
                    
                    'name' => 'D'
                    'section_id' => 1
                ]);                


        } 
    }
}
