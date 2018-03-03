<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('value');
            $table->boolean('disabled')->default(0);
            $table->timestamp('created_at')->nullable()->default(null);
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        DB::table('config')->insert([
            ['key' => 'favico',                     'value' => 'jipa.ico',                   'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'company',                    'value' => 'JIPA Network',               'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'logo',                       'value' => 'JIPA-Full-Logo.png',         'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'address',                    'value' => '3114 Commerce Parkway',      'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'city',                       'value' => 'Miramar',                    'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'state',                      'value' => 'FL',                         'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'zipcode',                    'value' => '33025 ',                     'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'country',                    'value' => 'US',                         'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'email',                      'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'phone',                      'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'fax',                        'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'website',                    'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'facebook',                   'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'twitter',                    'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'instagram',                  'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'linkedin',                   'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'defaultAvatar',              'value' => 'default-avatar-150x150.jpg', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'adminEmail',                 'value' => '',                           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'developerEmail',             'value' => 'user@localhost.com',         'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'defaultLanguage',            'value' => 'en',                         'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'simpleFormSubmission',       'value' => '1',                          'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'logUserAuthAction',          'value' => '0',                          'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultTitlePrefix_en',   'value' => 'JIPA | ',                    'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultTitlePrefix_sp',   'value' => 'JIPA | ',                    'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultTitle_en',         'value' => 'Joint Independent Provider Association', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultTitle_sp',         'value' => 'Joint Independent Provider Association', 'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultKeywords_en',      'value' => 'keywords',                               'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultKeywords_sp',      'value' => 'palabras claves',                        'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultDescription_en',   'value' => 'JIPA Network collaborates with medical experts, with state-of-the-art technologies and services, in order to provide patients with access to health care, critical medical services and elective procedures.',           'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
            ['key' => 'seoDefaultDescription_sp',   'value' => 'descripcion de la pagina',   'created_at' => '2015-12-16 00:00:00', 'updated_at' => '2015-12-16 00:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config');
    }

}
