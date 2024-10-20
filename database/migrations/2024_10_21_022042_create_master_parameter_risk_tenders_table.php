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
        if (!Schema::hasTable('master_parameter_risk_tenders')) {
            Schema::create('master_parameter_risk_tenders', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->text("deskripsi");
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
        Schema::dropIfExists('master_parameter_risk_tenders');
    }
};
