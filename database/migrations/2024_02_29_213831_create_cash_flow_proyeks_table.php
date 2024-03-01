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
        if (!Schema::hasTable('cash_flow_proyeks')) {
            Schema::create('cash_flow_proyeks', function (Blueprint $table) {
                $table->id();
                $table->string('kode_proyek');
                $table->string('nama_document');
                $table->string('id_document');
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
        Schema::dropIfExists('cash_flow_proyeks');
    }
};
