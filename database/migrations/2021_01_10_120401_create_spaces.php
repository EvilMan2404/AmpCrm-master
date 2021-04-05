<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_10_120401_create_spaces.php
*/

class CreateSpaces extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('spaces')) {
            Schema::create('spaces', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('title', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
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
        if (Schema::hasTable('spaces')) {


            Schema::dropIfExists('spaces');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
