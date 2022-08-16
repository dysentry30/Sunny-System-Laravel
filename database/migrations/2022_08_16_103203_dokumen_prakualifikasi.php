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
        Schema::create('dokumen_prakualifikasis', function (Blueprint $table) {
            $table->id('id_dokumen_prakualifikasi');
            $table->text("kode_proyek");
            $table->longText("nama_dokumen");
            $table->longText("id_document");
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
        Schema::dropIfExists('dokumen_prakualifikasis');
    }
};
