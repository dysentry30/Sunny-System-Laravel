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
        if (!Schema::hasTable('master_analisa_harga_satuan')) {
            Schema::create('master_analisa_harga_satuan', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kode_ahs', 15)->unique();
                $table->string('uraian');
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
        Schema::dropIfExists('master_analisa_harga_satuan');
    }
};
