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
        if (!Schema::hasTable('piutang_new')) {
            Schema::create('piutang_new', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('customer_id');
                $table->foreign('customer_id')->references('id_customer')->on('customers')->onDelete('cascade');
                $table->string('kode_proyek');
                $table->foreign('kode_proyek')->references('kode_proyek')->on('proyeks')->onDelete('cascade');
                $table->integer('kategori');
                $table->integer('under_90_day');
                $table->integer('between_90_120_day');
                $table->integer('upper_120_day');
                // $table->string('created_by');
                // $table->foreign('created_by')->references('nip')->on('users')->onDelete('cascade');
                // $table->string('updated_by');
                // $table->foreign('updated_by')->references('nip')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('piutang_new');
    }
};
