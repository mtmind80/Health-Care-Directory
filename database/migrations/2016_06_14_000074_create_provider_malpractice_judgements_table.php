<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderMalpracticeJudgementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('provider_malpractice_judgements', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('provider_id')->unsigned()->index();
			$table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->integer('provider_malpractice_id')->unsigned()->index();
            $table->foreign('provider_malpractice_id')->references('id')->on('provider_malpractices')->onDelete('cascade');
            $table->integer('offense_type_id ')->unsigned()->index();
            $table->foreign('offense_type_id')->references('id')->on('offense_types')->onDelete('cascade');
			$table->string('plaintiff_name', 100)->nullable()->default(null);
			$table->float('settled_amount')->nullable()->default(null);
			$table->boolean('defendant')->default(0);
			$table->boolean('dismissed')->default(0);
			$table->boolean('primary_sourced')->default(0);
			$table->date('occurred_at')->nullable()->default(null);
			$table->date('reported_at')->nullable()->default(null);
			$table->date('settled_at')->nullable()->default(null);
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
		Schema::drop('provider_malpractice_judgements');
	}

}
