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
        if (!Schema::hasColumn('peserta_tenders', 'status')) {
            Schema::table('peserta_tenders', function (Blueprint $table) {
                $table->string('status')->nullable();
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
        if (Schema::hasColumn('peserta_tenders', 'status')) {
            Schema::table('peserta_tenders', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
