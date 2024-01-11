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
        if (!Schema::hasColumn('kriteria_pengguna_jasa', 'item')) {
            Schema::table('kriteria_pengguna_jasa', function (Blueprint $table) {
                $table->text('item')->nullable();
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
        Schema::table('kriteria_pengguna_jasa', function (Blueprint $table) {
            $table->dropColumn('item');
        });
    }
};
