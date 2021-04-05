<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchasePaymentTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_payment_types')->delete();
        
        \DB::table('purchase_payment_types')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'Оплата наличными',
                'space_id' => 1,
                'created_at' => '2021-02-06 10:42:18',
                'updated_at' => '2021-02-06 10:42:18',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 5,
                'name' => 'Оплата банковским переводом',
                'space_id' => 1,
                'created_at' => '2021-02-06 10:42:26',
                'updated_at' => '2021-02-06 10:42:26',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 6,
                'name' => 'Оплата с корпоративной карты',
                'space_id' => 1,
                'created_at' => '2021-02-06 10:43:22',
                'updated_at' => '2021-02-06 10:43:22',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}