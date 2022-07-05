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
            $table->integer('id_user');
            // $table->string('nama_user');
            $table->string('kode_proyek');
            $table->boolean('proyek_selesai')->nullable();
            $table->timestamp('exp_proyek')->nullable();
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
