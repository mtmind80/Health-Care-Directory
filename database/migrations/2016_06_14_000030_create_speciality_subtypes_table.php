<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialitySubTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('speciality_subtypes', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('speciality_id')->unsigned()->index();
			$table->foreign('speciality_id')->references('id')->on('speciality_types')->onDelete('cascade');
            $table->string('name');
			$table->string('code', 15);
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
		Schema::drop('speciality_subtypes');
	}

}
