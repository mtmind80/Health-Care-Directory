<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredentialsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credentials', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('provider_id')->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->integer('professional_id')->unsigned()->index();
            $table->foreign('professional_id')->references('id')->on('professionals');
            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('credential_status');
            $table->integer('assigned_to_id')->unsigned()->index();
            $table->foreign('assigned_to_id')->references('id')->on('users');
            $table->dateTime('opened_at')->nullable()->default(null);
            $table->dateTime('completed_at')->nullable()->default(null);
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
        Schema::drop('credentials');
    }

}
