<?php

namespace Database\Seeders;

use App\Models\RoleHasUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use \App\Models\User;

/*
cd ./ && php artisan backup:run --only-db
php artisan db:seed --class=\Database\Seeders\UsersSeeder
*/

class PurchaseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('purchase_status')->delete();

        \DB::table('purchase_status')->insert(array(
            0 =>
                array(
                    'id'         => 1,
                    'name'       => 'Оценка лота',
                    'created_at' => '2021-01-15 21:52:33',
                    'updated_at' => '2021-01-15 21:52:33',
                    'deleted_at' => null,
                    'space_id'   => 1,
                ),
            1 =>
                array(
                    'id'         => 2,
                    'name'       => 'Стадия покупки',
                    'created_at' => '2021-01-15 21:52:33',
                    'updated_at' => '2021-01-15 21:52:33',
                    'deleted_at' => null,
                    'space_id'   => 1,
                ),
            2 =>
                array(
                    'id'         => 3,
                    'name'       => 'Аукцион выигран',
                    'created_at' => '2021-01-15 21:52:33',
                    'updated_at' => '2021-01-15 21:52:33',
                    'deleted_at' => null,
                    'space_id'   => 1,
                ),
            3 =>
                array(
                    'id'         => 4,
                    'name'       => 'Аукцион проигран',
                    'created_at' => '2021-01-15 21:52:35',
                    'updated_at' => '2021-01-15 21:52:35',
                    'deleted_at' => null,
                    'space_id'   => 1,
                )
        ));
    }

}
