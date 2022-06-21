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
        Schema::create('history_forecast', function (Blueprint $table) {
            $table->bigIncrements('id_history_forecast');
            $table->string('kode_proyek');
            $table->bigInteger('nilai_forecast');
            $table->mediumInteger('month_history_forecast');
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
        Schema::dropIfExists('history_forecast');
    }
};
