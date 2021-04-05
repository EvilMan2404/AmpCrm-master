<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        DB::beginTransaction();
        if (!Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->mediumtext('description')->nullable();
                $table->unsignedInteger('status_id')->index()->nullable();
                $table->timestamp('date_start');
                $table->timestamp('date_end');
                $table->string('source');
                $table->unsignedBigInteger('source_id');
                $table->unsignedInteger('priority_id')->index()->nullable();
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->unsignedInteger('assigned_user')->index()->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('tasks')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')
                    ->on('users');
                $table->foreign('assigned_user')->references('id')
                    ->on('users');
                $table->foreign('status_id')->references('id')
                    ->on('tasks_statuses');
                $table->foreign('priority_id')->references('id')
                    ->on('tasks_priorities');
            });
        }
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
