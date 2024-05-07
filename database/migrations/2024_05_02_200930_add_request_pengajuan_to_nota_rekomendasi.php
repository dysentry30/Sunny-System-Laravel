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
        if (!Schema::hasColumn('nota_rekomendasi', 'request_pengajuan')) {
            Schema::table('nota_rekomendasi', function (Blueprint $table) {
                $table->text('request_pengajuan')->nullable();
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
        if (Schema::hasColumn('nota_rekomendasi', 'request_pengajuan')) {
            Schema::table('nota_rekomendasi', function (Blueprint $table) {
                $table->dropColumn('request_pengajuan');
            });
        }
    }
};
