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
        if (!Schema::hasTable('analisa_harga_satuan_sumber_daya_formulas')) {
            Schema::create('analisa_harga_satuan_sumber_daya_formulas', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("kode_proyek")->nullable();
                $table->string("kode_tahap")->nullable();
                $table->string("kode_ahs")->nullable();
                $table->string("resource_code")->nullable();
                $table->float("basic_price")->nullable();
                $table->string("uom")->nullable();
                $table->float("harga")->nullable();
                $table->integer("index")->nullable();
                $table->text("formula");
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
        Schema::dropIfExists('analisa_harga_satuan_sumber_daya_formulas');
    }
};
