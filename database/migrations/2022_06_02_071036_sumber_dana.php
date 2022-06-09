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
        Schema::create('sumber_danas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sumber');
            $table->string('kategori');
            $table->string('unique_code');
            $table->string('jenis_perusahaan')->nullable();
            $table->string('tipe_lain')->nullable();
            $table->string('kode_sumber')->nullable();
            $table->string('sumber_dana_id')->nullable();
            $table->string('kode_proyek_id')->nullable();
            $table->string('tipe_perusahaan')->nullable();
            $table->string('cot_id')->nullable();
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
        Schema::dropIfExists('sumber_danas');
    }
};
