<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageProviderPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('language_provider', function(Blueprint $table)
		{
			$table->integer('provider_id')->unsigned()->index();
			$table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
			$table->integer('language_id')->unsigned()->index();
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
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
		Schema::drop('language_provider');
	}

}
