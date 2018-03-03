<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalBoardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('professional_boards', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned()->index();
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->integer('speciality_type_id')->unsigned()->index();
            $table->foreign('speciality_type_id')->references('id')->on('speciality_types')->onDelete('cascade');
            $table->integer('speciality_subtype_id')->unsigned()->index();
            $table->foreign('speciality_subtype_id')->references('id')->on('speciality_subtypes')->onDelete('cascade');
            $table->integer('body_id')->unsigned()->index();
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade');
            $table->integer('certification_id')->unsigned()->index();
            $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('cascade');
            $table->integer('state_id')->unsigned()->index();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->string('number', 50);
            $table->date('issued_at')->nullable()->default(null);
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
		Schema::drop('professional_boards');
	}

}
