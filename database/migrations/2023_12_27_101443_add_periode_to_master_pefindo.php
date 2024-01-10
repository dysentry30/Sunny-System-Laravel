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
        Schema::table('master_pefindo', function (Blueprint $table) {
            $table->integer('bulan_start');
            $table->integer('tahun_start');
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_pefindo', function (Blueprint $table) {
            $table->dropColumn(['bulan_start', 'tahun_start', 'is_active']);
        });
    }
};
