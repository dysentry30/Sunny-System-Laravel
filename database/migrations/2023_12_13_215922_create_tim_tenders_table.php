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
        Schema::create('tim_tenders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('nip_pegawai');
            $table->enum('posisi', ['Ketua', 'Anggota']);
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
        Schema::dropIfExists('tim_tenders');
    }
};
