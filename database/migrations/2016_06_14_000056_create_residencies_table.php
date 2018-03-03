<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('residencies', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('types')->onDelete('cascade');
            $table->integer('speciality_type_id')->unsigned()->index();
            $table->foreign('speciality_type_id')->references('id')->on('speciality_types')->onDelete('cascade');
			$table->integer('speciality_subtype_id')->unsigned()->index();
			$table->foreign('speciality_subtype_id')->references('id')->on('speciality_subtypes')->onDelete('cascade');
            $table->integer('hospital_id')->unsigned()->index();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->integer('degree_id')->unsigned()->index();
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
			$table->datetime('started_at')->nullable()->default(null);
			$table->datetime('ended_at')->nullable()->default(null);
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
		Schema::drop('residencies');
	}

}
