<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalIdentificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('professional_identifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('professional_id')->unsigned()->index();
			$table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
			$table->integer('identification_id')->unsigned()->index();
			$table->foreign('identification_id')->references('id')->on('identifications')->onDelete('cascade');
			$table->string('value');
            $table->date('expired_at')->nullable()->default(null);
			$table->dateTime('deleted_at')->nullable()->default(null);
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
		Schema::drop('professional_identifications');
	}

}
