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
        Schema::create('proyek_adendums', function (Blueprint $table) {
            $table->id();
            $table->string("kode_proyek");
            $table->string("nomor_adendum");
            $table->string("nilai_adendum");
            $table->string("pelanggan_adendum");
            $table->string("tanggal_adendum")->nullable();
            $table->string("tanggal_selesai_proyek")->nullable();
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
        Schema::dropIfExists('proyek_adendums');
    }
};
