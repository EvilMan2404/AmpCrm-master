<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lots', static function (Blueprint $table) {
            $table->foreignId('assigned_user')
                ->constrained('users')
                ->onDelete('cascade');
            $table->decimal('pt_weight_used', '17', '8')->index()->nullable();
            $table->decimal('pd_weight_used', '17', '8')->index()->nullable();
            $table->decimal('rh_weight_used', '17', '8')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lots', static function (Blueprint $table) {
            $table->dropColumn('pt_weight_used');
            $table->dropColumn('pd_weight_used');
            $table->dropColumn('rh_weight_used');
        });
    }
}
