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
        if (!Schema::hasTable('kriteria_probabilitas')) {
            Schema::create('kriteria_probabilitas', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->uuid('skala_id');
                $table->foreign("skala_id")->references("id")->on("master_skala_risk_tenders")->onDelete("cascade");
                $table->string("kriteria_probabilitas");
                $table->uuid("id_master_data_parameter");
                $table->foreign("id_master_data_parameter")->references("id")->on("master_parameter_risk_tenders")->onDelete("cascade");
                $table->text("keterangan");
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
        Schema::dropIfExists('kriteria_probabilitas');
    }
};
