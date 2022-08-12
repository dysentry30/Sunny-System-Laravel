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
        Schema::create('peserta_tenders', function (Blueprint $table) {
            $table->id();
            $table->string('peserta_tender');
            $table->string('kode_proyek');
            $table->string('nilai_tender_peserta')->nullable();
            $table->string('oe_tender')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('peserta_tenders');
    }
};
