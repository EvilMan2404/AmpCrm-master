<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_07_173140_create_users.php
*/

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('users')) {
            Schema::create('users', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('name', '255')->nullable();
                $table->string('third_name', '255')->nullable();
                $table->string('email', '255')->nullable();
                $table->string('phone', '255')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', '255')->nullable();
                $table->rememberToken();
                $table->unsignedInteger('country_id')->index()->nullable();
                $table->unsignedInteger('city_id')->index()->nullable();
                $table->string('street', '255')->nullable();
                $table->string('second_name', '255')->nullable();
                $table->string('address', '255')->nullable();
                $table->integer('assigned_user')->nullable()->default(0);
                $table->unsignedInteger('team_id')->index()->nullable();
                $table->string('card_number', '255')->nullable();
                $table->decimal('balance', '11', '2')->index()->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('space_id')->index()->nullable();
                $table->index(['assigned_user', ]);
            });
        }
        if (!Schema::hasTable('users')) {
            Schema::table('users', function(Blueprint $table) {
              $table->foreign('country_id')->references('id')
                    ->on('country');
              $table->foreign('city_id')->references('id')
                    ->on('city');
              $table->foreign('team_id')->references('id')
                    ->on('teams');
              $table->foreign('space_id')->references('id')
                    ->on('spaces');
            });
        }
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function down()
    {
        DB::beginTransaction();
        //..drop all tables
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('users')) {
            Schema::table('users', function(Blueprint $table) {

                  if(Schema::hasColumn('users', 'country_id')) {
                        $table->dropIndex(['country_id']);
                    }
                  if(Schema::hasColumn('users', 'city_id')) {
                        $table->dropIndex(['city_id']);
                    }
                  if(Schema::hasColumn('users', 'team_id')) {
                        $table->dropIndex(['team_id']);
                    }
                  if(Schema::hasColumn('users', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('users');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
