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
        if (!Schema::hasTable('master_produktivitas')) {
            Schema::create('master_produktivitas', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("resource_code");
                $table->foreign("resource_code")->references("code")->on("master_sumber_daya");
                $table->boolean("is_rumus")->default("false");
                $table->string("nilai_produktivitas");
                $table->float("bbm")->nullable();
                $table->float("jarak")->nullable();
                $table->float("kecepatan")->nullable();
                $table->float("muatan")->nullable();
                $table->float("konstanta")->nullable();
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
        Schema::dropIfExists('master_produktivitas');
    }
};
