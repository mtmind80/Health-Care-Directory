<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProceduresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('provider_procedures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('provider_id')->unsigned()->index();
			$table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
			$table->integer('procedure_id')->unsigned()->index();
			$table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('cascade');
			$table->text('comment');
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
		Schema::drop('provider_procedures');
	}

}
