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

        if (!Schema::hasColumns('nota_rekomendasi_2', ['file_kelengkapan_merge', 'file_assessment_merge'])) {
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->string('file_kelengkapan_merge')->nullable();
                $table->string('file_assessment_merge')->nullable();
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
        if (Schema::hasColumns('nota_rekomendasi_2', ['file_kelengkapan_merge', 'file_assessment_merge'])) {
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->dropColumn(['file_kelengkapan_merge', 'file_assessment_merge']);
            });
        }
    }
};
