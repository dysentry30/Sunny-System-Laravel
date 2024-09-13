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
        if (!Schema::hasColumn('users', 'role_scm')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean("role_scm")->default(false);
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
        if (Schema::hasColumn('users', 'role_scm')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(["role_scm"]);
            });
        }
    }
};
