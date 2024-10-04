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
        if (!Schema::hasTable('berita_acara_kesepakatan')) {
            Schema::create('berita_acara_kesepakatan', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('profit_center');
                $table->string('perubahan_id');
                $table->string('id_contract')->nullable();
                $table->string('nomor_dokumen')->nullable();
                $table->text('uraian_dokumen')->nullable();
                $table->string('id_document')->nullable();
                $table->string('nama_document')->nullable();
                $table->date('tanggal_dokumen')->nullable();
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
        Schema::dropIfExists('berita_acara_kesepakatan');
    }
};
