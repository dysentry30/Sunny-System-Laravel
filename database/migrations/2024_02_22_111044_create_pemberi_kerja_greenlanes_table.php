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
        if (!Schema::hasTable('except_greenlanes')) {
            Schema::create('except_greenlanes', function (Blueprint $table) {
                $table->id();
                $table->string('kategori');
                $table->string('sub_kategori');
                $table->string('item');
                $table->string('sub_item')->nullable();
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
        Schema::dropIfExists('except_greenlanes');
    }
};
