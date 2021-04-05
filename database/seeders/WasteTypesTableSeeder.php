<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WasteTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('waste_types')->delete();
        
        \DB::table('waste_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Растраты на транспорт',
                'space_id' => 1,
                'created_at' => '2021-02-15 02:06:36',
                'updated_at' => '2021-02-15 02:06:36',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}