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
        if (!Schema::hasColumn('pasal_kontraktual', 'profit_center')) {
            Schema::table('pasal_kontraktual', function (Blueprint $table) {
                $table->string('profit_center', 25)->nullable();
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
        if (Schema::hasColumn('pasal_kontraktual', 'profit_center')) {
            Schema::table('pasal_kontraktual', function (Blueprint $table) {
                $table->dropColumn('profit_center');
            });
        }
    }
};
