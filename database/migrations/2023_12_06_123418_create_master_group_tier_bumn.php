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
        Schema::create('master_group_tier_bumn', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            $table->string('nama_pelanggan');
            $table->enum('kategori', ['Tier A', 'Tier B', 'Tier C', 'Tier D']);
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
        Schema::dropIfExists('master_group_tier_bumn');
    }
};
