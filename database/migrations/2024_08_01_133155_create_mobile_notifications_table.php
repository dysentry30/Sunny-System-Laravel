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
        if (!Schema::hasTable('mobile_notifications')) {
            Schema::create('mobile_notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kode_proyek');
                $table->foreign('kode_proyek')->references('kode_proyek')->on('proyeks')->onDelete('cascade');
                $table->string('category', 25);
                $table->string('sub_category', 25);
                $table->text('message')->nullable();
                $table->string('item_date')->nullable();
                $table->string('nip')->nullable();
                $table->boolean('is_read')->nullable();
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
        Schema::dropIfExists('mobile_notifications');
    }
};
