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
                $table->string('resource_code', 15);
                $table->foreign('resource_code')->references('code')->on('master_sumber_daya')->onDelete('cascade');
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
