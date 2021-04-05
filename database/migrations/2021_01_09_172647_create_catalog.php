<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_09_172647_create_catalog.php
*/

class CreateCatalog extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('catalog')) {
            Schema::create('catalog', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('name', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->string('description', '255')->nullable();
                $table->string('serial_number', '255')->nullable();
                $table->unsignedInteger('car_brand')->index()->nullable();
                $table->decimal('pt', '17', '8')->index()->nullable();
                $table->decimal('pd', '17', '8')->index()->nullable();
                $table->decimal('rh', '17', '8')->index()->nullable();
                $table->decimal('weight', '17', '8')->index()->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('catalog')) {
            Schema::table('catalog', function(Blueprint $table) {
              $table->foreign('space_id')->references('id')
                    ->on('spaces');
              $table->foreign('car_brand')->references('id')
                    ->on('car_brand');
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
        if (Schema::hasTable('catalog')) {
            Schema::table('catalog', function(Blueprint $table) {
                  if(Schema::hasColumn('catalog', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
                  if(Schema::hasColumn('catalog', 'car_brand')) {
                        $table->dropIndex(['car_brand']);
                    }
            });

            Schema::dropIfExists('catalog');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
