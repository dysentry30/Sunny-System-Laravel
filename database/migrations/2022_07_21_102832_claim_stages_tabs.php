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
        Schema::create('claim_drafts', function (Blueprint $table) {
            $table->id('id_draft');
            $table->text("id_claim");
            $table->text("no_claim_draft");
            $table->longText("uraian_claim_draft");
            $table->longText("dokumen_pendukung");
            $table->longText("pasals");
            $table->bigInteger("pengajuan_biaya");
            $table->dateTime("pengajuan_waktu_eot");
            $table->text("id_document_proposal_claim");
            $table->boolean("rekomendasi");
            $table->longText("uraian_rekomendasi");
            $table->timestamps();
        });

        Schema::create('claim_diajukans', function (Blueprint $table) {
            $table->id('id_diajukans');
            $table->text("id_claim");
            $table->longText("dokumen_pendukung");
            $table->dateTime("tanggal_diajukan");
            $table->text("id_document_proposal_claim");
            $table->boolean("rekomendasi");
            $table->longText("uraian_rekomendasi");
            $table->timestamps();
        });
        
        Schema::create('claim_negosiasis', function (Blueprint $table) {
            $table->id('id_negosiasi');
            $table->text("id_claim");
            $table->longText("dokumen_pendukung");
            $table->longText("uraian_activity");
            $table->dateTime("tanggal_activity");
            $table->longText("keterangan");
            $table->timestamps();
        });

        Schema::create('claim_disetujuis', function (Blueprint $table) {
            $table->id('id_disetujui');
            $table->text("id_claim");
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
        Schema::dropIfExists('claim_drafts');
        Schema::dropIfExists('claim_diajukans');
        Schema::dropIfExists('claim_negosiasis');
        Schema::dropIfExists('claim_disetujuis');
    }
};
