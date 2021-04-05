<?php

namespace Database\Seeders;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleHasPermissions extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $roles = Roles::find(1);
        $roles ? $roles->permissions()->sync(Permissions::all()) : null;
    }
}