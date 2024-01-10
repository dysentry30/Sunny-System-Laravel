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
        Schema::table('proyeks', function (Blueprint $table) {
            $table->text('pekerjaan_utama')->nullable();
            $table->date('waktu_pemasukan_tender')->nullable();
            $table->date('waktu_jaminan_penawaran')->nullable();
            $table->date('waktu_prakualifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan_utama', 'waktu_pemasukan_tender', 'waktu_jaminan_penawaran', 'waktu_prakualifikasi']);
        });
    }
};
