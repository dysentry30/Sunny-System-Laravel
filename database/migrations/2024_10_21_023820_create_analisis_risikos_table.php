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
        if (!Schema::hasTable('analisis_risiko')) {
            Schema::create('analisis_risiko', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->uuid('kriteria_probabilitas_id');
                $table->foreign('kriteria_probabilitas_id')->references('id')->on('kriteria_probabilitas')->onDelete('cascade');
                $table->uuid('kriteria_dampak_kuantitatif_id');
                $table->foreign('kriteria_dampak_kuantitatif_id')->references('id')->on('kriteria_dampak_kuantitatif')->onDelete('cascade');
                $table->uuid('perlakuan_risiko_id');
                $table->foreign('perlakuan_risiko_id')->references('id')->on('perlakuan_risiko')->onDelete('cascade');
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
        Schema::dropIfExists('analisis_risiko');
    }
};
