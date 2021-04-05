<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_08_172823_create_country.php
*/

class CreateCountry extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('country')) {
            Schema::create('country', function(Blueprint $table) {
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
        if (Schema::hasTable('country')) {

            Schema::dropIfExists('country');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
