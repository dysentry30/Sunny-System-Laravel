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
        if (!Schema::hasColumns('porsi_jo_proyeks', ['is_hasil_assessment', 'hasil_assessment'])) {
            Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
                $table->boolean('is_hasil_assessment')->nullable();
                $table->string('hasil_assessment')->nullable();
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
        if (Schema::hasColumns('porsi_jo_proyeks', ['is_hasil_assessment', 'hasil_assessment'])) {
            Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
                $table->dropColumn(['is_hasil_assessment', 'hasil_assessment']);
            });
        }
    }
};
