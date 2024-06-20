<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        if (!Schema::hasTable('contract_approval_new')) {
            Schema::create('contract_approval_new', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('id_contract')->nullable();
                $table->string('profit_center')->nullable();
                $table->string('kode_proyek')->nullable();
                $table->string('jenis_perubahan');
                $table->string('proposal_klaim')->nullable();
                $table->integer('stage');
                $table->boolean('is_dispute')->default(false);
                $table->boolean('status')->default(false);
                $table->integer('periode_laporan');
                $table->integer('tahun');
                $table->boolean('is_request_unlock')->nullable();
                $table->boolean('is_locked')->default(false);
                $table->boolean('is_approved')->nullable();
                $table->string('unit_kerja');
                $table->date('tanggal_perubahan');
                $table->text('uraian_perubahan');
                $table->date('tanggal_pengajuan')->nullable();
                $table->date('waktu_pengajuan')->nullable();
                $table->string('biaya_pengajuan')->nullable();
                $table->date('tanggal_disetujui')->nullable();
                $table->date('waktu_disetujui')->nullable();
                $table->string('nilai_disetujui')->nullable();
                $table->string('dokumen_approve')->nullable();
                $table->string('id_dokumen')->nullable();
                $table->boolean('nilai_negatif')->default(false);
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
        Schema::dropIfExists('contract_approval_new');
    }
};
