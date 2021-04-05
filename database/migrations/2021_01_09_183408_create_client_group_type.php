<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_09_183408_create_client_group_type.php
*/

class CreateClientGroupType extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('client_group_type')) {
            Schema::create('client_group_type', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('title', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->string('space_id', '255')->nullable();
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
        if (Schema::hasTable('client_group_type')) {

            Schema::dropIfExists('client_group_type');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
