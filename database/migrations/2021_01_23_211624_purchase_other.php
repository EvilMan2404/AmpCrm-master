<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up(): void
    {
        DB::transaction(static function () {
            Schema::table('purchase_catalog', static function (Blueprint $table) {
                $table->decimal('discount', 17, 8)->default('0.00');
                $table->enum('discount_type', ['money', 'percent'])->nullable();
                $table->integer('count')->default('1');

            });
            Schema::table('purchase', static function (Blueprint $table) {
                $table->foreignId('user_id')->after('status_id')->nullable()
                    ->constrained('users')
                    ->onDelete('set null')->nullOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function down()
    {
        DB::transaction(static function () {
            Schema::table('purchase_catalog', static function (Blueprint $table) {
                $table->dropColumn('discount');
                $table->dropColumn('discount_type');
                $table->dropColumn('count');
//            $table->dropConstrainedForeignId('user_id');
            });
            Schema::table('purchase', static function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        });
    }
}
