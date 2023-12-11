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
        Schema::create('kriteria_greenlane_partner', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            $table->string('nama_pelanggan');
            $table->integer('start_bulan');
            $table->integer('start_tahun');
            $table->integer('finish_bulan')->nullable();
            $table->integer('finish_tahun')->nullable();
            $table->boolean('is_active');
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
        Schema::dropIfExists('kriteria_greenlane_partner');
    }
};
