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
        if (!Schema::hasTable('csi_master_kategori_pertanyaan')) {
            Schema::create('csi_master_kategori_pertanyaan', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kategori');
                $table->string('code');
                $table->integer('posisi');
                $table->boolean('is_active');
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
        Schema::dropIfExists('csi_master_kategori_pertanyaan');
    }
};
