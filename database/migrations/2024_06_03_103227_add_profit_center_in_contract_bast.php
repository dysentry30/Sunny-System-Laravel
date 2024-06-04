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
        if (!schema::hasColumn('contract_bast', 'profit_center')) {
            Schema::table('contract_bast', function (Blueprint $table) {
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
        if (Schema::hasColumn('contract_bast', 'profit_center')) {
            Schema::table('contract_bast', function (Blueprint $table) {
                $table->dropColumn(['profit_center']);
            });
        }
    }
};
