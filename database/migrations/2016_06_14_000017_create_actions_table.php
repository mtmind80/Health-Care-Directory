<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

		DB::table('actions')->insert([
			['id' => 1,  'name' => 'create',  'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 2,  'name' => 'update',  'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 3,  'name' => 'enable',  'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['id' => 4,  'name' => 'disable', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['id' => 5,  'name' => 'delete',  'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('actions');
	}

}
