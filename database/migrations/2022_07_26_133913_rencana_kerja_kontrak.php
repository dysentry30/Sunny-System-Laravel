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
        Schema::create('rencana_kerja_manajemens', function (Blueprint $table) {
            $table->id('id_rencana_kerja_manajemen');
            $table->bigInteger('id_contract');
            $table->longText("ketentuan_rencana_kerja");
            $table->longText("informasi_lengkap_adkon");
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
        Schema::dropIfExists('rencana_kerja_manajemens');
    }
};
