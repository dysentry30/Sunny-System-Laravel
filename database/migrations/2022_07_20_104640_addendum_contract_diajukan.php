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
        Schema::create('addendum_contract_diajukans', function (Blueprint $table) {
            $table->id('id_addendum_contract_diajukan');
            $table->integer('id_addendum');
            $table->text("id_document_proposal_addendum");
            $table->dateTime("tanggal_diajukan");
            $table->boolean("rekomendasi");
            $table->longText("uraian_rekomendasi");
            $table->longText("dokumen_pendukung")->nullable();
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
        Schema::dropIfExists('addendum_contract_diajukans');
    }
};
