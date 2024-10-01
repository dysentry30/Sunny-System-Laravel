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
        if (!Schema::hasTable('analisa_harga_satuan_details')) {
            Schema::create('analisa_harga_satuan_details', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kode_sumber_daya', 15);
                $table->foreign('kode_sumber_daya')->references('kode_sumber_daya')->on('master_sumber_daya')->onDelete('cascade');
                $table->string('kode_ahs', 15);
                $table->foreign('kode_ahs')->references('kode_ahs')->on('master_analisa_harga_satuan')->onDelete('cascade');
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
        Schema::dropIfExists('analisa_harga_satuan_details');
    }
};
