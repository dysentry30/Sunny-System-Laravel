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
        if (!Schema::hasColumns('porsi_jo_proyeks', ['kelemahan_partner', 'kekuatan_partner']))
            Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
                $table->text('kelemahan_partner')->nullable();
                $table->text('kekuatan_partner')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumns('porsi_jo_proyeks', ['kelemahan_partner', 'kekuatan_partner'])) {
            Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
                $table->dropColumn(['kelemahan_partner', 'kekuatan_partner']);
            });
        }
    }
};
