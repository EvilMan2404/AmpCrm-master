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

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spaces        = new \App\Models\Spaces();
        $spaces->title = 'Main';
        $spaces->save();
        $Teams        = new \App\Models\Teams();
        $Teams->name = 'Main';
        $Teams->save();
        $user             = new User();
        $user->name       = 'Admin';
        $user->third_name = 'Admin';
        $user->email      = 'admin@gmail.com';
        $user->password   = Hash::make('zaqwedc');
        $user->city_id    = 59463;
        $user->country_id = 144;
        $user->team_id = 1;
        $user->space_id = 1;
        $user->save();
        $role = new RoleHasUser();
        $role->role_id=1;
        $role->user_id=1;
        $role->save();
    }

}
