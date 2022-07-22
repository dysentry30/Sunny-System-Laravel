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
        Schema::create('addendum_contract_amandemens', function (Blueprint $table) {
            $table->id('id_addendum_contract_amandemen');
            $table->integer('id_addendum');
            $table->text("id_dokumen_amandemen");
            $table->dateTime("tanggal_amandemen");
            $table->bigInteger("biaya_amandemen");
            $table->dateTime("waktu_eot_amandemen");
            $table->longText("keterangan");
            $table->longText("dokumen_pendukung");
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
        Schema::dropIfExists('addendum_contract_amandemens');
    }
};
