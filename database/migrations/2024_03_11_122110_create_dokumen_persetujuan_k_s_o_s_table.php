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
        if (!Schema::hasTable('dokumen_persetujuan_kso')) {
            Schema::create('dokumen_persetujuan_kso', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kode_proyek');
                $table->string('id_document');
                $table->string('nama_document');
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
        Schema::dropIfExists('dokumen_persetujuan_kso');
    }
};
