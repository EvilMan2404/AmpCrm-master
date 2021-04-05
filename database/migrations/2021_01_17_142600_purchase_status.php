<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('purchase_status', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('space_id')
                ->constrained('spaces')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('purchase', static function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->after('total')
                ->constrained('purchase_status')
                ->onDelete('set null');
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
            $table->dropConstrainedForeignId('status_id');
        });
        Schema::dropIfExists('purchase_status');
    }
}
