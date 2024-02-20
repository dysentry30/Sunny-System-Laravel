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
        if (!Schema::hasColumns('nota_rekomendasi_2', ['is_request_paparan', 'is_paparan_revisi', 'revisi_paparan_note', 'tanggal_paparan_diajukan', 'tanggal_paparan_disetujui', 'file_pemaparan', 'file_absensi_paparan'])) {
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->boolean('is_request_paparan')->nullable();
                $table->boolean('is_paparan_revisi')->nullable();
                $table->text('revisi_paparan_note')->nullable();
                $table->date('tanggal_paparan_diajukan')->nullable();
                $table->date('tanggal_paparan_disetujui')->nullable();
                $table->string('file_pemaparan')->nullable();
                $table->string('file_absensi_paparan')->nullable();
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
        if (Schema::hasColumns('nota_rekomendasi_2', ['is_request_paparan', 'is_paparan_revisi', 'revisi_paparan_note', 'tanggal_paparan_diajukan', 'tanggal_paparan_disetujui', 'file_pemaparan', 'file_absensi_paparan'])) {
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->dropColumn(['is_request_paparan', 'is_paparan_revisi', 'revisi_paparan_note', 'tanggal_paparan_diajukan', 'tanggal_paparan_disetujui', 'file_pemaparan', 'file_absensi_paparan']);
            });
        }
    }
};
