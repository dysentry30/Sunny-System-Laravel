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
        Schema::create('penilaian_partner_selections', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('dari_nilai');
            $table->integer('sampai_nilai');
            $table->integer('start_bulan')->nullable();
            $table->integer('start_tahun')->nullable();
            $table->integer('finish_bulan')->nullable();
            $table->integer('finish_tahun')->nullable();
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
        Schema::dropIfExists('penilaian_partner_selections');
    }
};
