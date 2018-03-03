<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('internships', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('types')->onDelete('cascade');
            $table->integer('internship_type_id')->unsigned()->index();
            $table->foreign('internship_type_id')->references('id')->on('internship_types')->onDelete('cascade');
            $table->integer('hospital_id')->unsigned()->index();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->integer('discipline_id')->unsigned()->index();
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
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
		Schema::drop('internships');
	}

}
