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
        if (!Schema::hasTable('master_faktor_lain_lain')) {
            Schema::create('master_faktor_lain_lain', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("resource_code");
                // $table->foreign("resource_code")->references("code")->on("master_sumber_daya");
                $table->text("faktor");
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
        Schema::dropIfExists('master_faktor_lain_lain');
    }
};
