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
        if (!Schema::hasTable('master_sumber_daya')) {
            Schema::create('master_sumber_daya', function (Blueprint $table) {
                $table->uuid('id')->primary();
                // $table->string("kode_sumber_daya", 15)->unique();
                // $table->string("uraian");
                // $table->string("satuan");
                $table->string("resources_code_id")->nullable();
                $table->string("code");
                $table->string("parent_code")->nullable();
                $table->string("material_id")->nullable();
                $table->string("material_class")->nullable();
                $table->string("uoms_id")->nullable();
                $table->string("name")->nullable();
                $table->string("unspsc")->nullable();
                $table->string("unspsc_name")->nullable();
                $table->text("description")->nullable();
                $table->string("status")->nullable();
                $table->string("sts_matgis")->nullable();
                $table->string("sts_cm")->nullable();
                $table->string("material_ap")->nullable();
                $table->string("level")->nullable();
                $table->text("image")->nullable();
                $table->timestamp("approve_date")->nullable();
                $table->string("approve_by")->nullable();
                $table->string("created_by")->nullable();
                $table->timestamp("input_date")->nullable();
                $table->text("keterangan")->nullable();
                $table->string("uoms_name")->nullable();
                $table->string("jenis_material")->nullable();
                $table->string("material_code")->nullable();
                $table->string("material_name")->nullable();
                $table->string("valuation_class_code")->nullable();
                $table->string("valuation_class_name")->nullable();
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
        Schema::dropIfExists('master_sumber_daya');
    }
};
