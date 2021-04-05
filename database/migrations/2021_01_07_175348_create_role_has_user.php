<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_07_175348_create_role_has_user.php
*/

class CreateRoleHasUser extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('role_has_user')) {
            Schema::create('role_has_user', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->unsignedInteger('role_id')->index()->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('role_has_user')) {
            Schema::table('role_has_user', function(Blueprint $table) {
              $table->foreign('role_id')->references('id')
                    ->on('roles');
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
        if (Schema::hasTable('role_has_user')) {
            Schema::table('role_has_user', function(Blueprint $table) {
                  if(Schema::hasColumn('role_has_user', 'user_id')) {
                        $table->dropIndex(['user_id']);
                    }
                  if(Schema::hasColumn('role_has_user', 'role_id')) {
                        $table->dropIndex(['role_id']);
                    }
            });

            Schema::dropIfExists('role_has_user');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
