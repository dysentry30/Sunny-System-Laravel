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
        Schema::create('struktur_customer', function (Blueprint $table) {
            $table->id("id");
            $table->integer("id_customer");
            $table->mediumText("nama_struktur");
            $table->string("email_struktur")->nullable();
            $table->string("jabatan_struktur")->nullable();
            $table->string("phone_struktur")->nullable();
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
        Schema::dropIfExists('stuktur_customer');
    }
};
