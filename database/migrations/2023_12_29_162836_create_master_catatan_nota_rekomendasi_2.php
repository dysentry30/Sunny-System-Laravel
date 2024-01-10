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
        Schema::create('master_catatan_nota_rekomendasi_2', function (Blueprint $table) {
            $table->id();
            $table->integer('start_bulan');
            $table->integer('start_tahun');
            $table->integer('finish_bulan')->nullable();
            $table->integer('finish_tahun')->nullable();
            $table->string('kategori');
            $table->integer('urutan');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('master_catatan_nota_rekomendasi_2');
    }
};
