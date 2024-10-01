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
        if (!Schema::hasTable('master_sumber_daya')) {
            Schema::create('master_sumber_daya', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string("kode_sumber_daya", 15)->unique();
                $table->string("uraian");
                $table->string("satuan");
                $table->timestamps();
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
        Schema::dropIfExists('master_sumber_daya');
    }
};
