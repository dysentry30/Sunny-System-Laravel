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
        Schema::create('proyek_berjalans', function (Blueprint $table) {
            $table->id("id_proyek");
            $table->mediumInteger("id_customer");
            $table->mediumText("nama_proyek");
            $table->string("kode_proyek");
            $table->string("pic_proyek")->nullable();
            $table->string("unit_kerja");
            $table->string("jenis_proyek");
            $table->string("nilaiok_proyek");
            $table->string("stage");
            // $table->timestamp("created_at")->useCurrent();
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
        Schema::dropIfExists('proyek_berjalans');
    }
};
