<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamProviderPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exam_provider', function(Blueprint $table)
		{
			$table->integer('provider_id')->unsigned()->index();
			$table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
			$table->integer('exam_id')->unsigned()->index();
			$table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
			$table->datetime('started_at')->nullable()->default(null);
			$table->datetime('started_at')->nullable()->default(null);
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
		Schema::drop('exam_provider');
	}

}
