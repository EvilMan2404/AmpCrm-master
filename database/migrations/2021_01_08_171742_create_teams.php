<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_08_171742_create_teams.php
*/

class CreateTeams extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('teams')) {
            Schema::create('teams', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('name', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('teams')) {
            Schema::table('teams', function(Blueprint $table) {
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
        if (Schema::hasTable('teams')) {
            Schema::table('teams', function(Blueprint $table) {
                  if(Schema::hasColumn('teams', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('teams');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
