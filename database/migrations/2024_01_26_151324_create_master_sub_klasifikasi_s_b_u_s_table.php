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
        if (!Schema::hasTable('master_subklasifikasi_sbu')) {
            Schema::create('master_subklasifikasi_sbu', function (Blueprint $table) {
                $table->id();
                $table->string('klasifikasi_id');
                $table->string('subklasifikasi');
                $table->string('kode_subklasifikasi');
                $table->string('kbli_2020');
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
        Schema::dropIfExists('master_subklasifikasi_sbu');
    }
};
