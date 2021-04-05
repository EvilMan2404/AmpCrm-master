<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->decimal('weight_ceramics', '17', '8')->nullable();
            $table->decimal('analysis_pt', '17', '8')->nullable();
            $table->decimal('analysis_pd', '17', '8')->nullable();
            $table->decimal('analysis_rh', '17', '8')->nullable();
            $table->decimal('weight_dust', '17', '8')->nullable();
            $table->decimal('analysis_dust_pt', '17', '8')->nullable();
            $table->decimal('analysis_dust_pd', '17', '8')->nullable();
            $table->decimal('analysis_dust_rh', '17', '8')->nullable();
            $table->decimal('metallic', '17', '8')->nullable();
            $table->integer('catalyst')->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('stock');
    }
}
