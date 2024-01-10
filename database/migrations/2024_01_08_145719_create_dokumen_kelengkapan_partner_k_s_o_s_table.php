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
        Schema::create('dokumen_kelengkapan_partner_kso', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('kode_proyek');
            $table->string('id_partner');
            $table->string('kategori');
            $table->string('id_document');
            $table->string('nama_document');
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
        Schema::dropIfExists('dokumen_kelengkapan_partner_kso');
    }
};
