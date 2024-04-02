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
        if (!Schema::hasTable('master_alat_proyeks')) {
            Schema::create('master_alat_proyeks', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_rangka');
                $table->string('nama_alat');
                $table->text('spesifikasi');
                $table->string('kategori');
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
        Schema::dropIfExists('master_alat_proyeks');
    }
};
