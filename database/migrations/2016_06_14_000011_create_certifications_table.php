<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('certifications', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
			$table->string('code', 25);
            $table->integer('d_sort')->unsigned()->index()->default(0); // make "Other" option always at the end of the list
            $table->boolean('disabled')->default(0);
			$table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

		DB::table('certifications')->insert([
			['id' => 1,  'name' => 'State', 'code' => '1', 'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 2,  'name' => 'NCQA',  'code' => '2', 'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 3,  'name' => 'GHAA',  'code' => '3', 'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 4,  'name' => 'JCAHO', 'code' => '4', 'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 5,  'name' => 'AAAHC', 'code' => '5', 'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 6,  'name' => 'Other', 'code' => '6', 'd_sort' => '10000', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('certifications');
	}

}
