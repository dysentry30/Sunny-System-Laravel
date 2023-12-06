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
        Schema::create('dokumen_nota_rekomendasi_1', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('nama_dokumen');
            $table->string('id_document');
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
        Schema::dropIfExists('dokumen_nota_rekomendasi_1');
    }
};
