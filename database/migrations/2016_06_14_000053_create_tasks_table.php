<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('creator_id')->unsigned()->index();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->string('title');
            $table->integer('assigned_to_id')->unsigned()->index();
            $table->foreign('assigned_to_id')->references('id')->on('users');
            $table->text('content');
            $table->text('response');
            $table->boolean('reminder_sent')->default(0);
            $table->boolean('completed')->default(0);
            $table->date('due_at')->nullable()->default(null);
            $table->date('remind_at')->nullable()->default(null);
            $table->date('completed_at')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks');
    }

}
