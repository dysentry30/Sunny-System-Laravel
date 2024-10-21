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
        if (!Schema::hasTable('basic_prices')) {
            Schema::create('basic_prices', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("resource_code");
                $table->foreign("resource_code")->references("code")->on("master_sumber_daya")->onDelete("cascade");
                $table->integer("tahun");
                $table->string("province_id")->nullable();
                $table->string("kode_proyek")->nullable();
                $table->string("kode_vendor")->nullable();
                $table->string("nama_vendor")->nullable();
                $table->date("tanggal_penawaran")->nullable();
                $table->float("harga_satuan");
                $table->text("keterangan");
                $table->boolean("is_active")->default(true);
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
        Schema::dropIfExists('basic_prices');
    }
};
