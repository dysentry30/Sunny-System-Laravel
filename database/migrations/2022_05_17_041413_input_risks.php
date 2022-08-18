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
        Schema::create('input_risks', function (Blueprint $table) {
            $table->bigIncrements('id_risk');
            $table->text("id_contract");
            $table->longText("resiko");
            $table->longText("dampak");
            $table->longText("penyebab");
            $table->longText("mitigasi");
            $table->boolean("stage");
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
        Schema::dropIfExists('input_risks');
    }
};
