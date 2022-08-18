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
        Schema::create('usulan_perubahan_drafts', function (Blueprint $table) {
            $table->id('id_usulan_perubahan_draft');
            $table->text('id_contract');
            $table->text('id_review_draft');
            $table->tinyInteger('kategori');
            $table->longText('pasal_perbaikan');
            // $table->text("isu");
            // $table->longText("deskripsi_klausul_awal");
            // $table->longText("usulan_perubahan_klausul");
            $table->longText("keterangan");
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
        Schema::dropIfExists('usulan_perubahan_drafts');
    }
};
