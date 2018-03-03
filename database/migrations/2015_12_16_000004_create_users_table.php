<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->boolean('disabled')->default(0);
            $table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        DB::table('users')->insert([
            ['id' => 1, 'first_name' => 'Jose',     'last_name' => 'Vidal',         'email' => 'josei.vidal@yahoo.com',       'password' => '$2y$10$W1a.p9deK7Oh7cleqtQLp.ZcxfJe1CltkUb1HApm9Ccogc8P2Gpbm', 'avatar' => 'yo-470x450-fa3cf1.png',    'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['id' => 2, 'first_name' => 'Michael',  'last_name' => 'Trachtenberg',  'email' => 'mike.trachtenberg@gmail.com', 'password' => '$2y$10$jW4E/XTtlVbwbXMjWnzO2.MF.0Sp12dvZKuYVYfG/mMKkEF5LiR9W', 'avatar' => '150x150-miket-d510a9.png', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['id' => 3, 'first_name' => 'Admin',    'last_name' => 'User',          'email' => 'admin@test.com',              'password' => '$2y$10$MmwUVmMOBFphUQmoYQNJPO/aWukl2YdJ0zWNJWb05Wz9mlkneGaJm', 'avatar' => 'man-2.jpg', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['id' => 4, 'first_name' => 'Approver', 'last_name' => 'User',          'email' => 'approver@test.com',           'password' => '$2y$10$MmwUVmMOBFphUQmoYQNJPO/aWukl2YdJ0zWNJWb05Wz9mlkneGaJm', 'avatar' => 'girl-1.jpg',               'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['id' => 5, 'first_name' => 'User',     'last_name' => 'User',          'email' => 'authuser@test.com',           'password' => '$2y$10$MmwUVmMOBFphUQmoYQNJPO/aWukl2YdJ0zWNJWb05Wz9mlkneGaJm', 'avatar' => 'man-1.jpg',                'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
