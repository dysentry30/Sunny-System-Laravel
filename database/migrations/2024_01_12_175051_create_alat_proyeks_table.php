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
        if (!Schema::hasTable('alat_proyeks')) {
            Schema::create('alat_proyeks', function (Blueprint $table) {
                $table->id();
                $table->string('kode_proyek');
                $table->string('nomor_rangka');
                $table->string('kategori');
                $table->text('id_document')->nullable();
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
        Schema::dropIfExists('alat_proyeks');
    }
};
