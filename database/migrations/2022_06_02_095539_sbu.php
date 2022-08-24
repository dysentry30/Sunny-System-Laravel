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
        Schema::create('sbus', function (Blueprint $table) {
            $table->id();
            // $table->string('sbu');
            $table->string('kode_sbu');
            $table->string('klasifikasi');
            $table->string('sub_klasifikasi');
            $table->string('lingkup_kerja');
            $table->string('referensi1')->nullable();
            $table->string('referensi2')->nullable();
            $table->string('referensi3')->nullable();
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
        Schema::dropIfExists('sbus');
    }
};
