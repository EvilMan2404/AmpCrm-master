<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_status')->delete();
        
        \DB::table('purchase_status')->insert(array (
            0 => 
            array (
                'id' => 6,
                'name' => 'Сделка в ожидании',
                'space_id' => 1,
                'created_at' => '2021-02-06 10:41:55',
                'updated_at' => '2021-02-06 10:41:55',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 7,
                'name' => 'Отменена',
                'space_id' => 1,
                'created_at' => '2021-02-06 10:41:59',
                'updated_at' => '2021-02-06 10:41:59',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 8,
                'name' => 'Подтверждена',
                'space_id' => 1,
                'created_at' => '2021-02-06 10:42:05',
                'updated_at' => '2021-02-06 10:42:05',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}