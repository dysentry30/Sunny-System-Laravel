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
        if (!Schema::hasColumn('users', 'proyeks_selected')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('proyeks_selected')->nullable();
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
        if (Schema::hasColumn('users', 'proyeks_selected')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('proyeks_selected');
            });
        }
    }
};
