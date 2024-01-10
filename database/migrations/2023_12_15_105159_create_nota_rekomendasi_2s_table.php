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
        Schema::create('nota_rekomendasi_2', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('unit_kerja');
            $table->boolean('is_request_rekomendasi')->nullable();
            $table->boolean('is_pengajuan_approved')->nullable();
            $table->text('approved_pengajuan')->nullable();
            $table->text('file_pengajuan')->nullable();
            $table->boolean('is_penyusun_approved')->nullable();
            $table->text('approved_penyusun')->nullable();
            $table->text('catatan_nota_rekomendasi')->nullable();
            $table->boolean('is_verifikasi_approved')->nullable();
            $table->text('approved_verifikasi')->nullable();
            $table->boolean('is_rekomendasi_approved')->nullable();
            $table->text('approved_rekomendasi')->nullable();
            $table->boolean('is_disetujui')->nullable();
            $table->text('approved_persetujuan')->nullable();
            $table->text('file_persetujuan')->nullable();
            $table->boolean('is_draft_recommend_note')->nullable();
            $table->boolean('is_revisi')->nullable();
            $table->text('revisi_note')->nullable();
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
        Schema::dropIfExists('nota_rekomendasi_2');
    }
};
