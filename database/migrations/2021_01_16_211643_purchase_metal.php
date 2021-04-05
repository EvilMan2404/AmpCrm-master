<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseMetal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('purchase', static function (Blueprint $table) {
            $table->decimal('pt', '17', '8')->nullable();
            $table->decimal('pd', '17', '8')->nullable();
            $table->decimal('rh', '17', '8')->nullable();
            $table->decimal('weight', '17', '8')->nullable();
            $table->decimal('total', '17', '8')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('purchase', static function (Blueprint $table) {
            $table->dropColumn('pt');
            $table->dropColumn('pd');
            $table->dropColumn('rh');
            $table->dropColumn('weight');
            $table->dropColumn('total');
        });
    }
}
