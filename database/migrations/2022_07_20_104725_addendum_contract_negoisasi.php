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
        Schema::create('addendum_contract_negoisasis', function (Blueprint $table) {
            $table->id('id_addendum_contract_negoisasi');
            $table->integer('id_addendum');
            $table->text("uraian_activity");
            $table->dateTime("tanggal_activity");
            $table->longText("dokumen_pendukung");
            $table->longText("keterangan");
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
        Schema::dropIfExists('addendum_contract_negoisasis');
    }
};
