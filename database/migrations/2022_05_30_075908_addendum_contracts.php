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
        Schema::create('addendum_contracts', function (Blueprint $table) {
            $table->bigIncrements('id_addendum');
            $table->integer("id_contract");
            $table->integer("no_addendum");
            $table->mediumText("created_by");
            $table->date("start_date");
            $table->text("pasals");
            $table->tinyInteger("stages");
            $table->mediumInteger("addendum_contract_version");
            $table->boolean("tender_menang");
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
        Schema::dropIfExists('addendum_contracts');
    }
};
