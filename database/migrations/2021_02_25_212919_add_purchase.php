<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase',static function(Blueprint $table){
            $table->decimal('paid',11,2)->default(0.00);
            $table->foreignId('user_paid_id')->nullable()
                ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase',static function(Blueprint $table){
            $table->dropColumn('paid');
            $table->dropConstrainedForeignId('user_paid_id');
        });
    }
}
