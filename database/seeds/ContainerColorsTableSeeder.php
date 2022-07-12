<?php

use Illuminate\Database\Seeder;

class ContainerColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               DB::table('container_colors')->insert([
                    
                    'name' => '黒'
                ]);

               DB::table('container_colors')->insert([
                    
                    'name' => 'グレー'
                ]);
    }
}
