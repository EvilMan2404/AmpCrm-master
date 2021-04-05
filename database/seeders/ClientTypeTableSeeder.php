<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('client_type')->delete();
        
        \DB::table('client_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Тип пользователя №1',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Тип пользователя №2',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Тип пользователя №3',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
        ));
        
        
    }
}