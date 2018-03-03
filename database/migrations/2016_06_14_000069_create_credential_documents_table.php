<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredentialDocumentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credential_documents', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('credential_id')->unsigned()->index();
            $table->foreign('credential_id')->references('id')->on('credentials');
            $table->integer('document_type_id')->unsigned()->index();
            $table->foreign('document_type_id')->references('id')->on('document_types');
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
        Schema::drop('credential_documents');
    }

}
