<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class LotsFix
 */
class LotsFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('lots', static function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('lots', static function (Blueprint $table) {
            $table->foreignId('company_id')
                ->constrained('company')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('lots', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
            $table->dropColumn('name');
            $table->dropColumn('description');
        });
        Schema::table('lots', static function (Blueprint $table) {
            $table->string('company_id', '255')->nullable();
        });
        Schema::enableForeignKeyConstraints();
    }
}
