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
        Schema::create('matriks_approval_partner_selections', function (Blueprint $table) {
            $table->id();
            $table->integer('start_bulan');
            $table->integer('start_tahun');
            $table->integer('finish_bulan')->nullable();
            $table->integer('finish_tahun')->nullable();
            $table->boolean('is_active');
            $table->string('nama_pegawai');
            $table->string('title');
            $table->string('divisi_id');
            $table->string('departemen_code');
            $table->string('kode_unit_kerja')->nullable();
            // $table->string('klasifikasi_proyek');
            $table->string('kategori');
            $table->string('urutan')->nullable();
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
        Schema::dropIfExists('matriks_approval_partner_selections');
    }
};
