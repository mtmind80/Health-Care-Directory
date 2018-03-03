<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('provider_addresses', function(Blueprint $table)
		{
			$table->integer('provider_id')->unsigned()->index();
			$table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
			$table->integer('address_type_id')->unsigned()->index();
			$table->foreign('address_type_id')->references('id')->on('address_types')->onDelete('cascade');
			$table->string('address');
			$table->string('address_2', 50);
			$table->string('city', 100);
			$table->integer('state_id')->unsigned()->index();
			$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
			$table->integer('country_id')->unsigned()->index();
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->string('zipcode', 50);
			$table->datetime('deleted_at')->nullable()->default(null);
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
		Schema::drop('provider_addresses');
	}

}
