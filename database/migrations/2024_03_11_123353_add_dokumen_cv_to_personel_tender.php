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
        if (!Schema::hasColumns('personel_tender_proyeks', ['dokumen_cv_upload'])) {
            Schema::table('personel_tender_proyeks', function (Blueprint $table) {
                $table->string('dokumen_cv_upload')->nullable();
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
        if (Schema::hasColumns('personel_tender_proyeks', ['dokumen_cv_upload'])) {
            Schema::table('personel_tender_proyeks', function (Blueprint $table) {
                $table->dropColumn(['dokumen_cv_upload']);
            });
        }
    }
};
