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
        if (!Schema::hasColumn('proyeks', 'kategori_kalah')) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->string('kategori_kalah')->nullable();
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
        if (Schema::hasColumn('proyeks', 'kategori_kalah')) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->dropColumn('kategori_kalah');
            });
        }
    }
};
