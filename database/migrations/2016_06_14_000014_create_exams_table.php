<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exams', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->integer('d_sort')->unsigned()->index()->default(0); // make "No qualifying exam" option always at the end of the list
            $table->boolean('disabled')->default(0);
			$table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

		DB::table('exams')->insert([
			['id' => 1,  'name' => 'ECFMG',              'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 2,  'name' => 'FLEX',               'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 3,  'name' => 'USMLE',              'd_sort' => '0',     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
			['id' => 4,  'name' => 'No Qualifying Exam', 'd_sort' => '10000', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2016-06-14 00:00:00'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exams');
	}

}
