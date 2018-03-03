<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_user', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('role_id')->unsigned()->index();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});

		DB::table('role_user')->insert([
			['user_id' => 1, 'role_id' => 1],
			['user_id' => 2, 'role_id' => 2],
			['user_id' => 3, 'role_id' => 3],
			['user_id' => 4, 'role_id' => 4],
			['user_id' => 5, 'role_id' => 5],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('role_user');
	}

}
