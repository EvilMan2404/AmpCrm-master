<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SpaceHasRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('space_has_role')->delete();
        
        \DB::table('space_has_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'space_id' => 6,
                'role_id' => 1,
                'created_at' => '2021-02-10 18:48:58',
                'updated_at' => '2021-02-10 18:48:58',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'space_id' => 1,
                'role_id' => 1,
                'created_at' => '2021-02-10 18:52:23',
                'updated_at' => '2021-02-10 18:52:45',
                'deleted_at' => '2021-02-10 18:52:45',
            ),
            2 => 
            array (
                'id' => 3,
                'space_id' => 1,
                'role_id' => 1,
                'created_at' => '2021-02-10 18:52:45',
                'updated_at' => '2021-02-10 18:54:44',
                'deleted_at' => '2021-02-10 18:54:44',
            ),
            3 => 
            array (
                'id' => 4,
                'space_id' => 1,
                'role_id' => 1,
                'created_at' => '2021-02-10 18:54:44',
                'updated_at' => '2021-02-10 18:54:51',
                'deleted_at' => '2021-02-10 18:54:51',
            ),
            4 => 
            array (
                'id' => 5,
                'space_id' => 1,
                'role_id' => 6,
                'created_at' => '2021-02-10 18:54:44',
                'updated_at' => '2021-02-10 18:54:51',
                'deleted_at' => '2021-02-10 18:54:51',
            ),
            5 => 
            array (
                'id' => 6,
                'space_id' => 1,
                'role_id' => 6,
                'created_at' => '2021-02-10 18:54:51',
                'updated_at' => '2021-02-10 20:15:14',
                'deleted_at' => '2021-02-10 20:15:14',
            ),
            6 => 
            array (
                'id' => 7,
                'space_id' => 7,
                'role_id' => 1,
                'created_at' => '2021-02-10 18:58:31',
                'updated_at' => '2021-02-10 18:58:31',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'space_id' => 1,
                'role_id' => 1,
                'created_at' => '2021-02-10 20:15:14',
                'updated_at' => '2021-02-10 20:15:14',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'space_id' => 1,
                'role_id' => 7,
                'created_at' => '2021-02-10 20:15:14',
                'updated_at' => '2021-02-10 20:15:14',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}