<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IndustryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('industry')->delete();
        
        \DB::table('industry')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Индустрия №1',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Индустрия №2',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
        ));
        
        
    }
}