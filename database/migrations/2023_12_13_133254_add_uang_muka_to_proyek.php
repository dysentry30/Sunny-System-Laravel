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
        if (!Schema::hasColumns('proyeks', ['is_uang_muka', 'uang_muka'])) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->boolean('is_uang_muka')->nullable();
                $table->string('uang_muka')->nullable();
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
        if (Schema::hasColumns('proyeks', ['is_uang_muka', 'uang_muka'])) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->dropColumn(['is_uang_muka', 'uang_muka']);
            });
        }
    }
};
