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
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_unit');
            $table->string('unit_kerja')->unique();
            $table->string('divcode')->unique();
            $table->string('dop');
            $table->string('company');
            $table->string('divisi')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('metode_approval')->nullable();
            $table->longText('user_1')->nullable();
            $table->longText('user_2')->nullable();
            $table->longText('user_3')->nullable();
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
        Schema::dropIfExists('unit_kerjas');
    }
};
