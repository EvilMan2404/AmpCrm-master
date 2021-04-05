<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Discount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', static function (Blueprint $table) {
            $table->id();
            $table->integer('pt_discount' )->nullable();
            $table->integer('pd_discount')->nullable();
            $table->integer('rh_discount')->nullable();
            $table->foreignId('space_id')
                ->constrained('spaces')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount');
    }
}
