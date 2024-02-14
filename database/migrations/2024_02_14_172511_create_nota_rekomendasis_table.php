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
        if (!Schema::hasTable('nota_rekomendasi')) {
            Schema::create('nota_rekomendasi', function (Blueprint $table) {
                $table->id();
                $table->string('kode_proyek');
                $table->string('unit_kerja');
                $table->string('divisi_id');
                $table->string('departemen_code');
                $table->string('klasifikasi_pasdin');
                $table->boolean('is_request_rekomendasi')->nullable();
                $table->boolean('review_assessment')->nullable();
                $table->text('approved_rekomendasi')->nullable();
                $table->string('file_pengajuan')->nullable();
                $table->text('hasil_assessment')->nullable();
                $table->boolean('is_revisi_pengajuan')->nullable();
                $table->text('revisi_pengajuan_note')->nullable();
                $table->string('file_rekomendasi')->nullable();
                $table->boolean('is_penyusun_approved')->nullable();
                $table->text('approved_penyusun')->nullable();
                $table->string('file_penilaian_risiko')->nullable();
                $table->boolean('is_draft_recommend_note')->nullable();
                $table->text('recommended_with_note')->nullable();
                $table->text('catatan_nota_rekomendasi')->nullable();
                $table->boolean('is_verifikasi_approved')->nullable();
                $table->text('approved_verifikasi')->nullable();
                $table->boolean('is_recommended')->nullable();
                $table->boolean('is_recommended_with_note')->nullable();
                $table->text('approved_rekomendasi_final')->nullable();
                $table->boolean('is_disetujui')->nullable();
                $table->text('approved_persetujuan')->nullable();
                $table->text('persetujuan_note')->nullable();
                $table->string('file_persetujuan')->nullable();
                $table->boolean('is_revisi')->nullable();
                $table->text('revisi_note')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_rekomendasi');
    }
};
