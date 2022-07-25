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
        Schema::create('pending_issues', function (Blueprint $table) {
            $table->id('id_pending_issue');
            $table->bigInteger('id_contract');
            $table->longText("issue"); // bisa id dokumen ataupun teks biasa
            $table->boolean("status");
            $table->longText("penyebab");
            $table->bigInteger("biaya");
            $table->dateTime("waktu");
            $table->longText("mutu");
            $table->longText("ancaman");
            $table->longText("peluang");
            $table->longText("rencana_tindak_lanjut");
            $table->dateTime("target_waktu_penyelesaian");
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
        Schema::dropIfExists('pending_issues');
    }
};
