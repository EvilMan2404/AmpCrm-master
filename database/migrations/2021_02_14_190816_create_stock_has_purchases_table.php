<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHasPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_has_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->nullable()
                ->constrained('stock')
                ->onDelete('cascade');
            $table->foreignId('purchase_id')->nullable()
                ->constrained('purchase')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('stock_has_purchases');
    }
}
