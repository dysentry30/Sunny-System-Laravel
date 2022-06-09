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
            $table->integer("id_contract")->unique();
            $table->mediumText("project_id");
            $table->mediumText("contract_proceed");
            $table->tinyInteger("stages");
            $table->dateTime("contract_in");
            $table->dateTime("contract_out");
            $table->bigInteger("number_spk");
            $table->bigInteger("value");
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
