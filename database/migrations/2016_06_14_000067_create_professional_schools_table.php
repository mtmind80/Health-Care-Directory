<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalSchoolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('professional_schools', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('professional_id')->unsigned()->index();
			$table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
			$table->integer('school_id')->unsigned()->index();
			$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
			$table->integer('degree_id')->unsigned()->index();
			$table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
			$table->text('comment')->nullable()->default(null);
            $table->date('started_at')->nullable()->default(null);
			$table->date('ended_at')->nullable()->default(null);
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
		Schema::drop('professional_schools');
	}

}
