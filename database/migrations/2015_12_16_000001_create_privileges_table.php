<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('privileges', function(Blueprint $table) {
            $table->increments('id');
            $table->string('privilege_name');
            $table->boolean('disabled')->default(0);
			$table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

		DB::table('privileges')->insert([
			['id' => 1,  'privilege_name' => 'list-user', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 2,  'privilege_name' => 'search-user', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 3,  'privilege_name' => 'show-user', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 4,  'privilege_name' => 'create-user', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 5,  'privilege_name' => 'update-user', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 6,  'privilege_name' => 'delete-user', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 7,  'privilege_name' => 'list-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 8,  'privilege_name' => 'search-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 9,  'privilege_name' => 'show-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 10, 'privilege_name' => 'create-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 11, 'privilege_name' => 'update-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 12, 'privilege_name' => 'modify-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 13, 'privilege_name' => 'delete-role', 		'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 14, 'privilege_name' => 'list-privilege',   'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 15, 'privilege_name' => 'search-privilege', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 16, 'privilege_name' => 'show-privilege',   'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 17, 'privilege_name' => 'create-privilege', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 18, 'privilege_name' => 'update-privilege', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 19, 'privilege_name' => 'modify-privilege', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 20, 'privilege_name' => 'delete-privilege', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 21, 'privilege_name' => 'list-config',     	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 22, 'privilege_name' => 'search-config', 	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 23, 'privilege_name' => 'show-config',   	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 24, 'privilege_name' => 'create-config', 	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 25, 'privilege_name' => 'update-config', 	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 26, 'privilege_name' => 'modify-config', 	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 27, 'privilege_name' => 'delete-config', 	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 28, 'privilege_name' => 'list-login', 	    'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 29, 'privilege_name' => 'search-login', 	'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
			['id' => 30, 'privilege_name' => 'show-login', 	    'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('privileges');
	}

}
