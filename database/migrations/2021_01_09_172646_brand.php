<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Brand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        Schema::create('car_brand', function (Blueprint $table) {
            $table->id();
            $table->engine = 'InnoDB';
            $table->string('name');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->unsignedInteger('space_id')->index()->nullable();
        });
        if (!Schema::hasTable('car_brand')) {
            Schema::table('car_brand', function (Blueprint $table) {
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
        if (Schema::hasTable('car_brand')) {
            Schema::table('car_brand', function (Blueprint $table) {
                if (Schema::hasColumn('car_brand', 'space_id')) {
                    $table->dropIndex(['space_id']);
                }
            });

            Schema::dropIfExists('car_brand');
        }
        Schema::enableForeignKeyConstraints();
        DB::commit();
    }
}
