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
        Schema::create('kriteria_penilaian_pefindo', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("grade");
            $table->integer("dari_nilai");
            $table->integer("sampai_nilai");
            $table->string("probability_of_default")->nullable();
            $table->integer("start_bulan")->nullable();
            $table->integer("start_tahun")->nullable();
            $table->integer("finish_bulan")->nullable();
            $table->integer("finish_tahun")->nullable();
            $table->boolean("is_active")->nullable();
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
        Schema::dropIfExists('kriteria_penilaian_pefindo');
    }
};
