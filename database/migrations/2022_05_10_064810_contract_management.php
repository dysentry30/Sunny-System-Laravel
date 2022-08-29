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
        Schema::create("contract_managements", function (Blueprint $table) {
            $table->id();
            $table->mediumText("id_contract");
            $table->mediumText("project_id");
            $table->mediumText("contract_proceed");
            $table->tinyInteger("stages");
            $table->dateTime("contract_in");
            $table->dateTime("contract_out");
            $table->text("dokumen_bast_1")->nullable();
            $table->text("dokumen_bast_2")->nullable();
            $table->longText("list_dokumen_ba_defect")->nullable();
            $table->longText("dokumen_pendukung")->nullable();
            $table->longText("dokumen_kontrak_dan_addendum")->nullable();
            $table->text("number_spk");
            $table->bigInteger("value");
            $table->bigInteger("value_review");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("contract_managements");
    }
};
