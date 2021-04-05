<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpaceIdToIssuanceOfFinance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issuance_of_finance', function (Blueprint $table) {
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
        Schema::table('issuance_of_finance', function (Blueprint $table) {
            //
        });
    }
}
