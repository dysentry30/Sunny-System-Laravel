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
        Schema::create('team_proyeks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_team');
            $table->string('nama_proyek');
            $table->string('kode_proyek');
            $table->integer('stage');
            $table->timestamp('proyek_selesai')->nullable();
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
        Schema::dropIfExists('team_proyeks');
    }
};
