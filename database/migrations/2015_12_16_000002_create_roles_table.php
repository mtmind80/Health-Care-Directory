<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('role_name');
            $table->boolean('disabled')->default(0);
			$table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

		DB::table('roles')->insert([
			['id' => 1,  'role_name' => 'root',       'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 2,  'role_name' => 'superadmin', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 3,  'role_name' => 'admin',      'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 4,  'role_name' => 'approver',   'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 5,  'role_name' => 'user',       'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
