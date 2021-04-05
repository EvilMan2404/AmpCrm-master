<?php

namespace Database\Seeders;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array(
            0 =>
                array(
                    'id'         => 1,
                    'name'       => 'Главный администратор',
                    'guard_name' => 'cms_panel',
                    'created_at' => null,
                    'updated_at' => '2021-02-08 01:37:14',
                    'deleted_at' => null,
                ),
            1 =>
                array(
                    'id'         => 7,
                    'name'       => 'Администратор',
                    'guard_name' => 'cms_panel',
                    'created_at' => null,
                    'updated_at' => '2021-02-08 01:37:14',
                    'deleted_at' => null,
                ),
        ));
    }
}