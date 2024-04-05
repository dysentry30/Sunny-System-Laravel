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
        if (!Schema::hasTable('csi_master_pertanyaan')) {
            Schema::create('csi_master_pertanyaan', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('kategori');
                $table->string('parent')->nullable();
                $table->string('sub_parent')->nullable();
                $table->text('pertanyaan_indonesia');
                $table->text('pertanyaan_inggris');
                $table->string('bobot');
                $table->enum('tipe_input', ['pilihan', 'text']);
                $table->integer('jumlah_pilihan')->nullable();
                $table->integer('pilihan_jawaban');
                $table->integer('posisi');
                $table->boolean('is_active')->default(true);
                $table->date('start_periode');
                $table->date('finish_periode')->nullable();
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
        Schema::dropIfExists('csi_master_pertanyaan');
    }
};
