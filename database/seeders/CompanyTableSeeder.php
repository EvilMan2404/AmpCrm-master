<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('company')->delete();

        \DB::table('company')->insert(array(

            1 =>
                array(
                    'id'                          => 1,
                    'name'                        => 'HyundaiCompany PRESENTS',
                    'created_at'                  => '2021-01-15 14:30:36',
                    'updated_at'                  => '2021-01-15 22:33:00',
                    'deleted_at'                  => null,
                    'logo_id'                     => null,
                    'website'                     => 'hyunai.com',
                    'description'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tempus erat, id convallis orci. Nulla leo urna, rutrum a sodales sit amet, porta vitae purus. Aliquam egestas mi quis ante tempor, sit amet suscipit velit mattis. Donec aliquet urna ut placerat imperdiet. Phasellus luctus nisi sit amet odio eleifend gravida. Fusce vitae ipsum id sapien auctor pharetra nec sed augue. Proin elit nulla, tincidunt ac neque sit amet, suscipit laoreet quam. Nunc eget est sed libero ultrices gravida sit amet in nisi. Maecenas mattis nibh eu leo tempus porttitor. Praesent eu sollicitudin enim. Sed nec lacinia purus, eu pretium nisl.

Sed pharetra et quam non tincidunt. Nulla placerat, purus eget vehicula imperdiet, erat nunc bibendum enim, non luctus leo ipsum sit amet erat. Aenean sit amet orci id lectus porta posuere. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer efficitur, purus id tincidunt lacinia, dolor magna congue sem, eu porta urna orci sed dolor. In hac habitasse platea dictumst. Morbi varius vestibulum leo sed suscipit. Donec egestas, mi vel euismod ornare, odio leo consectetur lacus, eget bibendum risus augue sit amet nisi.',
                    'email'                       => 'hyunai@gmail.com',
                    'phone'                       => '011 236 59 77',
                    'billing_address_country'     => '229',
                    'billing_address_state'       => 'Nishi-Ku',
                    'billing_address_city'        => '1049372',
                    'billing_address_street'      => 'Minatomirai Center Bldg 16F, 3-6-1',
                    'billing_address_postal_code' => '893159',
                    'billing_address'             => '68581668133',
                    'shipping_address'            => 'Minatomirai Center Bldg 16F, 3-6-1',
                    'payment_info'                => '68581668133',
                    'last_user_id'                => 1,
                    'space_id'                    => 1,
                ),
        ));
    }
}