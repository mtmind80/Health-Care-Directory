<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsurersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insurers', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('address');
			$table->string('address_2', 50);
			$table->string('city', 100);
			$table->integer('state_id')->unsigned()->index();
			$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
			$table->string('zipcode', 50);
			$table->string('contact_name', 150);
			$table->string('email', 100);
			$table->string('phone', 100);
			$table->string('fax', 100);
            $table->boolean('disabled')->default(0);
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
		Schema::drop('insurers');
	}

}
