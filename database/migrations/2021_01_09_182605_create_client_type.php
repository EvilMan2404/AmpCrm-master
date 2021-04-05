<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_09_182605_create_client_type.php
*/

class CreateClientType extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('client_type')) {
            Schema::create('client_type', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('title', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('client_type')) {
            Schema::table('client_type', function(Blueprint $table) {
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
        if (Schema::hasTable('client_type')) {
            Schema::table('client_type', function(Blueprint $table) {

                  if(Schema::hasColumn('client_type', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('client_type');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
