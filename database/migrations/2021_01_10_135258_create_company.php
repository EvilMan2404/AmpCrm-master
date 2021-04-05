<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
cd ./ && php artisan backup:run --only-db
php artisan migrate --path=/database/migrations/2021_01_10_135258_create_company.php
*/

class CreateCompany extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('company')) {
            Schema::create('company', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('name', '255')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
                $table->unsignedInteger('logo_id')->index()->nullable();
                $table->string('website', '255')->nullable();
                $table->string('description', '255')->nullable();
                $table->string('email', '255')->nullable();
                $table->string('phone', '255')->nullable();
                $table->string('billing_address_country', '255')->nullable();
                $table->string('billing_address_state', '255')->nullable();
                $table->string('billing_address_city', '255')->nullable();
                $table->string('billing_address_street', '255')->nullable();
                $table->string('billing_address_postal_code', '255')->nullable();
                $table->string('billing_address', '255')->nullable();
                $table->string('shipping_address', '255')->nullable();
                $table->string('payment_info', '255')->nullable();
                $table->unsignedInteger('last_user_id')->index()->nullable();
                $table->unsignedInteger('space_id')->index()->nullable();
            });
        }
        if (!Schema::hasTable('company')) {
            Schema::table('company', function(Blueprint $table) {
              $table->foreign('logo_id')->references('id')
                    ->on('files');
              $table->foreign('last_user_id')->references('id')
                    ->on('users');
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
        if (Schema::hasTable('company')) {
            Schema::table('company', function(Blueprint $table) {
                  if(Schema::hasColumn('company', 'logo_id')) {
                        $table->dropIndex(['logo_id']);
                    }
                  if(Schema::hasColumn('company', 'last_user_id')) {
                        $table->dropIndex(['last_user_id']);
                    }
                  if(Schema::hasColumn('company', 'space_id')) {
                        $table->dropIndex(['space_id']);
                    }
            });

            Schema::dropIfExists('company');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }

}
