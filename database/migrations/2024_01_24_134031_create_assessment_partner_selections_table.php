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
        if (!Schema::hasTable('assessment_partner_selections')) {
            Schema::create('assessment_partner_selections', function (Blueprint $table) {
                $table->id();
                $table->string('kode_proyek');
                $table->string('partner_id');
                $table->string('divisi_id');
                $table->string('departemen_id');
                $table->boolean('is_pengajuan_approved')->nullable();
                $table->text('approved_pengajuan')->nullable();
                $table->boolean('is_revisi')->nullable();
                $table->text('approved_revisi')->nullable();
                $table->boolean('is_disetujui')->nullable();
                $table->text('approved_disetujui')->nullable();
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
        Schema::dropIfExists('assessment_partner_selections');
    }
};
