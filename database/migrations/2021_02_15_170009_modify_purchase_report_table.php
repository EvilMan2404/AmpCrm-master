<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_reports', function (Blueprint $table) {
            $table->longText('history')->nullable();
            $table->decimal('total_lots', 17, 3)->nullable();
            $table->decimal('total_waste', 17, 3)->nullable();
            $table->decimal('total', 17, 3)->nullable();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('space_id')
                ->constrained('spaces')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_reports', function (Blueprint $table) {
            //
        });
    }
}
