<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_07_173141_create_role_has_permissions.php
*/

class CreateRoleHasPermissions extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('role_has_permissions')) {
            Schema::create('role_has_permissions', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->unsignedBigInteger('permission_id')->nullable();
                $table->unsignedBigInteger('role_id')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
            });
        }
        DB::commit();
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        DB::beginTransaction();
        //..drop all tables
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('role_has_permissions')) {

            Schema::dropIfExists('role_has_permissions');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
