<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_08_172905_create_city.php
*/

class CreateCity extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('city')) {
            Schema::create('city', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('title', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('country_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('city')) {
            Schema::table('city', function(Blueprint $table) {
              $table->foreign('country_id')->references('id')
                    ->on('country');
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
        if (Schema::hasTable('city')) {
            Schema::table('city', function(Blueprint $table) {
                  if(Schema::hasColumn('city', 'country_id')) {
                        $table->dropIndex(['country_id']);
                    }
            });

            Schema::dropIfExists('city');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
