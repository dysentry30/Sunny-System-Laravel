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
        if (!Schema::hasTable('csi_kalkulasi_jawaban')) {
            Schema::create('csi_kalkulasi_jawaban', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('csi_id');
                $table->foreign('csi_id')->references('id_csi')->on('proyek_csi')->onDelete('cascade');
                $table->string('no_spk');
                $table->float('nilai');
                $table->integer('index');
                $table->string('kategori');
                $table->string('keterangan');
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
        Schema::dropIfExists('csi_kalkulasi_jawaban');
    }
};
