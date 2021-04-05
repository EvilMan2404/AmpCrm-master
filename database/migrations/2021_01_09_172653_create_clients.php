<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_09_172653_create_clients.php
*/

class CreateClients extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('name', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->string('second_name', '255')->nullable();
                $table->string('third_name', '255')->nullable();
                $table->string('phone', '255')->nullable();
                $table->string('client_type', '255')->nullable();
                $table->string('industry_id', '255')->nullable();
                $table->string('description', '255')->nullable();
                $table->string('billing_address_street', '255')->nullable();
                $table->string('billing_address_city', '255')->nullable();
                $table->string('billing_address_state', '255')->nullable();
                $table->string('billing_address_country', '255')->nullable();
                $table->string('billing_name_bank', '255')->nullable();
                $table->string('sic', '255')->nullable();
                $table->string('shipping_address_street', '255')->nullable();
                $table->string('shipping_address_city', '255')->nullable();
                $table->string('shipping_address_state', '255')->nullable();
                $table->string('shipping_address_country', '255')->nullable();
                $table->string('shipping_address_postal_code', '255')->nullable();
                $table->string('assigned_user_id', '255')->nullable();
                $table->string('billing_bank_account', '255')->nullable();
                $table->unsignedInteger('group_id')->index()->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('clients')) {
            Schema::table('clients', function(Blueprint $table) {
              $table->foreign('group_id')->references('id')
                    ->on('client_group_type');
              $table->foreign('space_id')->references('title')
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
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function(Blueprint $table) {
                  if(Schema::hasColumn('clients', 'group_id')) {
                        $table->dropIndex(['group_id']);
                    }
                  if(Schema::hasColumn('clients', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('clients');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
