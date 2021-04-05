<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_10_143255_create_lots.php
*/

class CreateLots extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('lots')) {
            Schema::create('lots', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('company_id', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->decimal('pt_weight', '17', '8')->index()->nullable();
                $table->decimal('pd_weight', '17', '8')->index()->nullable();
                $table->decimal('pt_rate', '17', '8')->index()->nullable();
                $table->decimal('rh_weight', '17', '8')->index()->nullable();
                $table->decimal('pd_rate', '17', '8')->index()->nullable();
                $table->decimal('rh_rate', '17', '8')->index()->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('lots')) {
            Schema::table('lots', function(Blueprint $table) {
              $table->foreign('user_id')->references('id')
                    ->on('users');
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
    */
    public function down()
    {
        DB::beginTransaction();
        //..drop all tables
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('lots')) {
            Schema::table('lots', function(Blueprint $table) {
                  if(Schema::hasColumn('lots', 'user_id')) {
                        $table->dropIndex(['user_id']);
                    }
                  if(Schema::hasColumn('lots', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('lots');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
