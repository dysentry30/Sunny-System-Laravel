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
        Schema::create('kriteria_pasar_proyeks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('kategori');
            $table->string('kriteria');
            $table->float('bobot');
            $table->float('jumlah_bobot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriteria_pasar_proyeks');
    }
};
