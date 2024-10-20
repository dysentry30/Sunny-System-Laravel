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
        if (!Schema::hasTable('kriteria_dampak_kuantitatif')) {
            Schema::create('kriteria_dampak_kuantitatif', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer("skala_id");
                $table->string("kriteria_dampak");
                $table->integer("range_start");
                $table->integer("range_end");
                $table->text("deskripsi");
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
        Schema::dropIfExists('kriteria_dampak_kuantitatif');
    }
};
