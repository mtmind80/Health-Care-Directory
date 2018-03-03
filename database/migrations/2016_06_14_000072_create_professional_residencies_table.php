<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalResidenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('professional_residencies', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned()->index();
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->integer('speciality_type_id')->unsigned()->index();
            $table->foreign('speciality_type_id')->references('id')->on('speciality_types')->onDelete('cascade');
			$table->integer('speciality_subtype_id')->unsigned()->index();
			$table->foreign('speciality_subtype_id')->references('id')->on('speciality_subtypes')->onDelete('cascade');
            $table->integer('degree_id')->unsigned()->index();
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
			$table->integer('discipline_id')->unsigned()->index();
			$table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
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
		Schema::drop('professional_residencies');
	}

}
