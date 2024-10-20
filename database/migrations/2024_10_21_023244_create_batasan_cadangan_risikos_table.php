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
        if (!Schema::hasTable('batasan_cadangan_risiko')) {
            Schema::create('batasan_cadangan_risiko', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("tipe_kontrak");
                $table->string("cara_pembayaran");
                $table->float("percentage");
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
        Schema::dropIfExists('batasan_cadangan_risiko');
    }
};
