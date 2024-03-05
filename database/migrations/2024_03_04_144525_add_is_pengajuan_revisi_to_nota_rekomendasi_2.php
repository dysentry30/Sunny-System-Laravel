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
        if (!Schema::hasColumns('nota_rekomendasi_2', ['is_revisi_pengajuan', 'revisi_pengajuan_note'])) {
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->boolean('is_revisi_pengajuan')->nullable();
                $table->string('revisi_pengajuan_note')->nullable();
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
        if (Schema::hasColumns('nota_rekomendasi_2', ['is_revisi_pengajuan', 'revisi_pengajuan_note'])) {
            Schema::table('nota_rekomendasi_2', function (Blueprint $table) {
                $table->dropColum(['is_revisi_pengajuan', 'revisi_pengajuan_note']);
            });
        }
    }
};
