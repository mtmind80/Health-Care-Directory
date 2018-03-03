<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalAffiliationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('professional_affiliations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned()->index();
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
			$table->integer('facility_id')->unsigned()->index();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->text('comment')->nullable()->default(null);
			$table->date('started_at')->nullable()->default(null);
			$table->date('ended_at')->nullable()->default(null);
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
		Schema::drop('professional_affiliations');
	}

}
