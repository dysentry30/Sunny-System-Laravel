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
        Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
            $table->boolean('is_disetujui')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
            $table->boolean('is_disetujui');
        });
    }
};