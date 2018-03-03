<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegeRolePivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('privilege_role', function(Blueprint $table)
		{
			$table->integer('privilege_id')->unsigned()->index();
			$table->foreign('privilege_id')->references('id')->on('privileges')->onDelete('cascade');
			$table->integer('role_id')->unsigned()->index();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});

		DB::table('privilege_role')->insert([
			['role_id' => 2, 'privilege_id' => 1],
			['role_id' => 2, 'privilege_id' => 2],
			['role_id' => 2, 'privilege_id' => 3],
			['role_id' => 2, 'privilege_id' => 4],
			['role_id' => 2, 'privilege_id' => 5],
			['role_id' => 2, 'privilege_id' => 6],
			['role_id' => 2, 'privilege_id' => 7],
			['role_id' => 2, 'privilege_id' => 8],
			['role_id' => 2, 'privilege_id' => 9],
			['role_id' => 2, 'privilege_id' => 10],
			['role_id' => 2, 'privilege_id' => 11],
			['role_id' => 2, 'privilege_id' => 12],
			['role_id' => 2, 'privilege_id' => 13],
			['role_id' => 2, 'privilege_id' => 14],
			['role_id' => 2, 'privilege_id' => 15],
			['role_id' => 2, 'privilege_id' => 16],
			['role_id' => 2, 'privilege_id' => 17],
			['role_id' => 2, 'privilege_id' => 18],
			['role_id' => 2, 'privilege_id' => 19],
			['role_id' => 2, 'privilege_id' => 20],
			['role_id' => 2, 'privilege_id' => 21],
			['role_id' => 2, 'privilege_id' => 22],
			['role_id' => 2, 'privilege_id' => 23],
			['role_id' => 2, 'privilege_id' => 24],
			['role_id' => 2, 'privilege_id' => 25],
			['role_id' => 2, 'privilege_id' => 26],
			['role_id' => 2, 'privilege_id' => 27],

			['role_id' => 3, 'privilege_id' => 28],
			['role_id' => 3, 'privilege_id' => 29],
			['role_id' => 3, 'privilege_id' => 30],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('privilege_role');
	}

}
