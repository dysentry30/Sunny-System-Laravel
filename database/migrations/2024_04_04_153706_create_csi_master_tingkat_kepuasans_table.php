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
        if (!Schema::hasTable('csi_master_tingkat_kepuasan')) {
            Schema::create('csi_master_tingkat_kepuasan', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kategori');
                $table->integer('dari');
                $table->integer('sampai');
                $table->boolean('is_active')->default(true);
                $table->date('start_periode');
                $table->date('finish_periode')->nullable();
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
        Schema::dropIfExists('csi_master_tingkat_kepuasan');
    }
};
