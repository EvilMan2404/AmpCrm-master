<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReportHasWastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_report_has_wastes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_id')->nullable()
                ->constrained('waste_types')
                ->onDelete('cascade');
            $table->foreignId('report_id')->nullable()
                ->constrained('purchase_reports')
                ->onDelete('cascade');
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
        Schema::dropIfExists('purchase_report_has_wastes');
    }
}
