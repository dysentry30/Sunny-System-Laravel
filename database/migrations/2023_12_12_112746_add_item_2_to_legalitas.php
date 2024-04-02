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
        if (!Schema::hasColumns('legalitas_perusahaan', ['item_2', 'position'])) {
            Schema::table('legalitas_perusahaan', function (Blueprint $table) {
                $table->text('item_2')->nullable();
                $table->integer('position')->nullable();
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
        if (Schema::hasColumns('legalitas_perusahaan', ['item_2', 'position'])) {
            Schema::table('legalitas_perusahaan', function (Blueprint $table) {
                $table->dropColumn(['item_2', 'position']);
            });
        }
    }
};
