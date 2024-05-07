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
        if (!Schema::hasColumn('assessment_partner_selections', 'catatan_assessment')) {
            Schema::table('assessment_partner_selections', function (Blueprint $table) {
                $table->text('catatan_assessment')->nullable();
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
        if (Schema::hasColumn('assessment_partner_selections', 'catatan_assessment')) {
            Schema::table('assessment_partner_selections', function (Blueprint $table) {
                $table->dropColumn('catatan_assessment');
            });
        }
    }
};
