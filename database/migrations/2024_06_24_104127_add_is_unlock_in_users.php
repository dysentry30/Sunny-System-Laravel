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
        if (!Schema::hasColumn('users', 'is_unlock')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean("is_unlock")->default(false);
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
        if (Schema::hasColumn('users', 'is_unlock')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(["is_unlock"]);
            });
        }
    }
};
