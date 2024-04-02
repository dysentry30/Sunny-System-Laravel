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
        if (!Schema::hasColumn('proyeks', 'lingkup_pekerjaan')) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->string('lingkup_pekerjaan')->nullable();
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
        if (Schema::hasColumn('proyeks', 'lingkup_pekerjaan')) {
            Schema::table('proyeks', function (Blueprint $table) {
                $table->dropColumn('lingkup_pekerjaan');
            });
        }
    }
};
