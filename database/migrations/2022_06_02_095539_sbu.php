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
            $table->string('sbu');
            $table->string('kode_sbu')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('referensi1')->nullable();
            $table->string('sub_klasifikasi')->nullable();
            $table->string('referensi2')->nullable();
            $table->string('lingkup_kerja')->nullable();
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
