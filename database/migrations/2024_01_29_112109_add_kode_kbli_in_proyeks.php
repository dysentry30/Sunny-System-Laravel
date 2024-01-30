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
        if (!Schema::hasColumn('proyeks', 'kode_kbli_2020')) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->string('kode_kbli_2020')->nullable();
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
        if (Schema::hasColumn('proyeks', 'kode_kbli_2020')) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->dropColumn('kode_kbli_2020')->nullable();
            });
        }
    }
};
