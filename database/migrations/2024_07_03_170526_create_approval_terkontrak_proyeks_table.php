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
        if (!Schema::hasTable('approval_terkontrak_proyeks')) {
            Schema::create('approval_terkontrak_proyeks', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("kode_proyek", 15);
                $table->foreign('kode_proyek')->references('kode_proyek')->on('proyeks')->onDelete('cascade');
                $table->string("unit_kerja", 1);
                $table->boolean("is_request_approval");
                $table->string("request_by");
                $table->dateTime("request_on");
                $table->boolean("is_approved")->nullable();
                $table->string("approved_by")->nullable();
                $table->dateTime("approved_on")->nullable();
                $table->boolean("is_revisi")->nullable();
                $table->string("revisi_by")->nullable();
                $table->dateTime("revisi_on")->nullable();
                $table->text("revisi_note")->nullable();
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
        Schema::dropIfExists('approval_terkontrak_proyeks');
    }
};
