<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_08_174433_create_issuance_of_finance.php
*/

class CreateIssuanceOfFinance extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('issuance_of_finance')) {
            Schema::create('issuance_of_finance', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->unsignedInteger('assigned_user')->index()->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->decimal('amount', '11', '2')->index()->nullable();
                $table->string('name', '255')->nullable();
                $table->string('description', '255')->nullable();
            });
        }
        if (!Schema::hasTable('issuance_of_finance')) {
            Schema::table('issuance_of_finance', function(Blueprint $table) {
              $table->foreign('assigned_user')->references('id')
                    ->on('users');
              $table->foreign('user_id')->references('id')
                    ->on('users');
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
        if (Schema::hasTable('issuance_of_finance')) {
            Schema::table('issuance_of_finance', function(Blueprint $table) {
                  if(Schema::hasColumn('issuance_of_finance', 'assigned_user')) {
                        $table->dropIndex(['assigned_user']);
                    }
                  if(Schema::hasColumn('issuance_of_finance', 'user_id')) {
                        $table->dropIndex(['user_id']);
                    }
            });

            Schema::dropIfExists('issuance_of_finance');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
