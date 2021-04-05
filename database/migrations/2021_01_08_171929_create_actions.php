<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_08_171929_create_actions.php
*/

class CreateActions extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('actions')) {
            Schema::create('actions', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->string('description', '255')->nullable();
                $table->string('model_type', '255')->nullable();
                $table->string('model_id', '255')->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('actions')) {
            Schema::table('actions', function(Blueprint $table) {
              $table->foreign('user_id')->references('id')
                    ->on('users');
              $table->foreign('space_id')->references('title')
                    ->on('spaces');
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
        if (Schema::hasTable('actions')) {
            Schema::table('actions', function(Blueprint $table) {
                  if(Schema::hasColumn('actions', 'user_id')) {
                        $table->dropIndex(['user_id']);
                    }
                  if(Schema::hasColumn('actions', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('actions');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
