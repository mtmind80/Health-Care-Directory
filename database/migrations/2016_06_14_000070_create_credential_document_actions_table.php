<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredentialDocumentActionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credential_document_actions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('document_id')->unsigned()->index();
            $table->foreign('document_id')->references('id')->on('credential_documents');
            $table->integer('action_type_id')->unsigned()->index();
            $table->foreign('action_type_id')->references('id')->on('document_action_types');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('comment')->nullable()->default(null);
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
        Schema::drop('credential_document_actions');
    }

}
