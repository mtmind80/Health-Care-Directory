<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderMalpracticesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('provider_malpractices', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->integer('insurer_id')->unsigned()->index();
            $table->foreign('insurer_id')->references('id')->on('insurers')->onDelete('cascade');
			$table->integer('policy_type_id')->unsigned()->index();
			$table->foreign('policy_type_id')->references('id')->on('policy_types')->onDelete('cascade');
            $table->string('policy_number', 100);
			$table->string('per_occurance')->nullable()->default(null);
			$table->string('in_aggregate')->nullable()->default(null);
			$table->boolean('insurance_proof')->default(0);
			$table->boolean('primary_sourced')->default(0);
			$table->date('retroactive_at')->nullable()->default(null);
			$table->date('started_at')->nullable()->default(null);
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
		Schema::drop('provider_malpractices');
	}

}
