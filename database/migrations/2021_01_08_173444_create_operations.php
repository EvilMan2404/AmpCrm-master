<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_08_173444_create_operations.php
*/

class CreateOperations extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('operations')) {
            Schema::create('operations', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->string('inbox_finance', '255')->nullable();
                $table->string('outbox_finance', '255')->nullable();
                $table->string('total_amount', '255')->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('operations')) {
            Schema::table('operations', function(Blueprint $table) {
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
        if (Schema::hasTable('operations')) {
            Schema::table('operations', function(Blueprint $table) {
                  if(Schema::hasColumn('operations', 'user_id')) {
                        $table->dropIndex(['user_id']);
                    }
                  if(Schema::hasColumn('operations', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('operations');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
