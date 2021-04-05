<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_10_120713_create_space_has_role.php
*/

class CreateSpaceHasRole extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('space_has_role')) {
            Schema::create('space_has_role', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->unsignedInteger('space_id')->index()->nullable();
                $table->unsignedInteger('role_id')->index()->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('space_has_role')) {
            Schema::table('space_has_role', function(Blueprint $table) {
              $table->foreign('space_id')->references('id')
                    ->on('spaces');
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
        if (Schema::hasTable('space_has_role')) {
            Schema::table('space_has_role', function(Blueprint $table) {
                  if(Schema::hasColumn('space_has_role', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
                  if(Schema::hasColumn('space_has_role', 'role_id')) {
                        $table->dropIndex(['role_id']);
                    }
            });

            Schema::dropIfExists('space_has_role');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
