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
        if (!Schema::hasColumn('user_menu_management', 'lock') || !Schema::hasColumn('user_menu_management', 'approve')) {
            Schema::table('user_menu_management', function (Blueprint $table) {
                $table->boolean('lock')->default(false);
                $table->boolean('approve')->default(false);
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
        if (Schema::hasColumn('user_menu_management', 'lock') || Schema::hasColumn('user_menu_management', 'approve')) {
            Schema::table('user_menu_management', function (Blueprint $table) {
                $table->dropColumn(['lock', 'approve']);
            });
        }
    }
};
