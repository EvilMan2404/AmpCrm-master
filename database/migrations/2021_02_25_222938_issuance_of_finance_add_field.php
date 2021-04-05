<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IssuanceOfFinanceAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issuance_of_finance', static function (Blueprint $table) {
            $table->decimal('balance', 11, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issuance_of_finance', static function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
}
