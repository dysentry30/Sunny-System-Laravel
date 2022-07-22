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
            $table->id('id_addendum_draft');
            $table->integer('id_addendum');
            $table->integer('id_contract');
            $table->longText('id_document_instruksi');
            $table->boolean('rekomendasi');
            $table->longText('uraian_rekomendasi');
            $table->longText('uraian_perubahan');
            $table->dateTime('pengajuan_waktu');
            $table->longText('id_document_draft_proposal_addendum');
            $table->longText('pasals');
            $table->text('document_name_addendum');
            $table->longText('list_id_document_pendukung');
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
