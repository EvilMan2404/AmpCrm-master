<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_catalog',static function(Blueprint $table){
            $table->foreignId( 'purchase_id' )
                ->constrained( 'purchase' )
                ->onDelete( 'cascade' );
            $table->foreignId( 'catalog_id' )
                ->constrained( 'catalog' )
                ->onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_catalog');
    }
}
