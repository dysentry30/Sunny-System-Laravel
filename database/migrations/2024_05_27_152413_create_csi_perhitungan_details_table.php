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
        if (!Schema::hasTable('csi_perhitungan_details')) {
            Schema::create('csi_perhitungan_details', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('csi_id')->nullable();
                $table->foreign('csi_id')->references('id_csi')->on('proyek_csi')->onDelete('cascade');
                $table->string('no_spk')->nullable();
                $table->string('unit_kerja')->nullable();
                $table->string('parameter')->nullable();
                $table->string('nilai')->nullable();
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
        Schema::dropIfExists('csi_perhitungan_details');
    }
};
