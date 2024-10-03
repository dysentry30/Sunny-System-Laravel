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
        if (!Schema::hasTable('master_harga_satuan')) {
            Schema::create('master_harga_satuan', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string("resource_code");
                // $table->foreign("resource_code")->references("code")->on("master_sumber_daya")->onDelete("cascade");
                $table->string("harga");
                $table->string("province_id");
                $table->foreign("province_id")->references("province_id")->on("province")->onDelete("cascade");
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
        Schema::dropIfExists('master_harga_satuan');
    }
};
