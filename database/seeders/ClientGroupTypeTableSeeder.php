<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientGroupTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('client_group_type')->delete();
        
        \DB::table('client_group_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Группа пользователя №1',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => '1',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Группа пользователя №2',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'space_id' => '1',
            ),
        ));
        
        
    }
}