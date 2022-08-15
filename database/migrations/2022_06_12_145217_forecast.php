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
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id("id_forecast");
            $table->string("kode_proyek");
            $table->bigInteger('nilai_forecast');
            $table->mediumInteger('month_forecast')->nullable();
            $table->bigInteger('rkap_forecast')->nullable();
            $table->mediumInteger('month_rkap')->nullable();
            $table->bigInteger('realisasi_forecast')->nullable();
            $table->mediumInteger('month_realisasi')->nullable();
            $table->tinyInteger('periode_prognosa');
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
        Schema::dropIfExists('forecasts');
    }
};
