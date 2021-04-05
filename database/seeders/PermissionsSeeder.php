<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use \App\Models\Permissions;
/*
cd ./ && php artisan backup:run --only-db
php artisan db:seed --class=\Database\Seeders\PermissionsSeeder
*/

class PermissionsSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
     public function run()
    {
        DB::table((new Permissions)->getTable())->insert(['id' => '1', 'guard_name' => 'cms_panel', ]);
    }

}
