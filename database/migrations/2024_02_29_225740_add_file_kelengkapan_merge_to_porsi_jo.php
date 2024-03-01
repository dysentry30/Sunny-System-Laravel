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
        if (!Schema::hasColumns('porsi_jo_proyeks', ['file_kelengkapan_merge', 'file_assessment_merge'])) {
            Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
                $table->string('file_kelengkapan_merge')->nullable();
                $table->string('file_assessment_merge')->nullable();
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
        if (Schema::hasColumns('porsi_jo_proyeks', ['file_kelengkapan_merge', 'file_assessment_merge'])) {
            Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
                $table->dropColumn(['file_kelengkapan_merge', 'file_assessment_merge']);
            });
        }
    }
};
