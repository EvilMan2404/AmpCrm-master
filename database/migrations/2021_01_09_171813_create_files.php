<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_09_171813_create_files.php
*/

class CreateFiles extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('files')) {
            Schema::create('files', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('name', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->string('file', '255')->nullable();
                $table->string('ext', '255')->nullable();
                $table->integer('size')->nullable();
                $table->string('model_type', '255')->nullable();
                $table->string('model_id', '255')->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('files')) {
            Schema::table('files', function(Blueprint $table) {
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
        if (Schema::hasTable('files')) {
            Schema::table('files', function(Blueprint $table) {
                  if(Schema::hasColumn('files', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('files');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
