<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addendum_contract_drafts', function (Blueprint $table) {
            $table->bigIncrements('id_addendum_draft');
            $table->integer('id_addendum');
            $table->mediumText('id_document');
            $table->text('document_name_addendum');
            $table->longText('note_addendum');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addendum_contract_drafts');
    }
};
