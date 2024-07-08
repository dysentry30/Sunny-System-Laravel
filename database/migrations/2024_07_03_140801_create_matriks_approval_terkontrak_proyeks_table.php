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
        if (!Schema::hasTable('matriks_approval_terkontrak_proyeks')) {
            Schema::create('matriks_approval_terkontrak_proyeks', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('nip', 15);
                $table->string('nama_pegawai');
                $table->string('unit_kerja', 1);
                $table->date('start_date');
                $table->date('finish_date')->nullable();
                $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('matriks_approval_terkontrak_proyeks');
    }
};
