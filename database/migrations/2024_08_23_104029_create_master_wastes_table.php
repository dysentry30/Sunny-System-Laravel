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
        if (!Schema::hasTable('master_waste')) {
            Schema::create('master_waste', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("kode_sumber_daya");
                $table->foreign("kode_sumber_daya")->references("kode_sumber_daya")->on("master_sumber_daya");
                $table->float("nilai_waste");
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
        Schema::dropIfExists('master_waste');
    }
};
