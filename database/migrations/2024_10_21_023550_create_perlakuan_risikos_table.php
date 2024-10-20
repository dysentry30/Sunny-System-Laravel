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
        if (!Schema::hasTable('perlakuan_risiko')) {
            Schema::create('perlakuan_risiko', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('level_risiko');
                $table->integer('opsi_perlakuan_risiko');
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
        Schema::dropIfExists('perlakuan_risiko');
    }
};
