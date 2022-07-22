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
        Schema::create('addendum_contract_disetujuis', function (Blueprint $table) {
            $table->id('id_addendum_contract_disetujui');
            $table->integer('id_addendum');
            $table->text("id_document_surat_disetujui");
            $table->dateTime("tanggal_disetujui");
            $table->bigInteger("biaya_disetujui");
            $table->dateTime("waktu_eot_disetujui");
            $table->longText("keterangan");
            $table->longText("dokumen_pendukung");
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
        Schema::dropIfExists('addendum_contract_disetujuis');
    }
};
