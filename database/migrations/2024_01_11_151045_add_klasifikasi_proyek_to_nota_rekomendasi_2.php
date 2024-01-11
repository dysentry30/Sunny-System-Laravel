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
        if (Schema::hasTable('nota_rekomendasi_2') && !Schema::hasColumn('nota_rekomendasi_2', 'klasifikasi_proyek'))
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->string('klasifikasi_proyek')->nullable();
                $table->string('divisi_id')->nullable();
                $table->string('departemen_proyek')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
            $table->dropColumn(['klasifikasi_proyek', 'divisi_id', 'departemen_proyek']);
        });
    }
};
