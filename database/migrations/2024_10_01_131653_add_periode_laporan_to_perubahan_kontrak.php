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
        if (!Schema::hasColumn('perubahan_kontrak', 'periode_laporan') || !Schema::hasColumn('perubahan_kontrak', 'tahun')) {
            Schema::table('perubahan_kontrak', function (Blueprint $table) {
                $table->integer("periode_laporan")->nullable();
                $table->integer("tahun")->nullable();
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
        if (Schema::hasColumn('perubahan_kontrak', 'periode_laporan') || Schema::hasColumn('perubahan_kontrak', 'tahun')) {
            Schema::table('perubahan_kontrak', function (Blueprint $table) {
                $table->dropColumn(["periode_laporan", "tahun"]);
            });
        }
    }
};
