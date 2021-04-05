<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReportHasLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_report_has_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->nullable()
                ->constrained('stock')
                ->onDelete('cascade');
            $table->foreignId('report_id')->nullable()
                ->constrained('purchase_reports')
                ->onDelete('cascade');
            $table->decimal('total', 17, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_report_has_lots');
    }
}
