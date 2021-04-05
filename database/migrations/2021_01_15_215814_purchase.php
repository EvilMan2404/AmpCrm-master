<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Purchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase',static function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId( 'lot_id' )
                ->constrained( 'lots' )
                ->onDelete( 'cascade' );
            $table->foreignId( 'space_id' )
                ->constrained( 'spaces' )
                ->onDelete( 'cascade' );
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
