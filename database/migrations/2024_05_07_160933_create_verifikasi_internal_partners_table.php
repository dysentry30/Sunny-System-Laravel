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
        if (!Schema::hasTable('verifikasi_internal_partners')) {
            Schema::create('verifikasi_internal_partners', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kode_proyek');
                $table->foreign('kode_proyek')->references('kode_proyek')->on('proyeks')->onDelete('cascade');
                $table->string('unit_kerja');
                $table->string('divisi_id');
                $table->string('departemen_id');
                $table->string('stage');
                $table->boolean('is_request_pengajuan')->nullable();
                $table->text('request_pengajuan')->nullable();
                $table->boolean('is_pengajuan_approved')->nullable();
                $table->text('pengajuan_approved')->nullable();
                $table->boolean('is_rekomendasi_approved')->nullable();
                $table->text('rekomendasi_approved')->nullable();
                $table->boolean('is_persetujuan_approved')->nullable();
                $table->text('persetujuan_approved')->nullable();
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
        Schema::dropIfExists('verifikasi_internal_partners');
    }
};
