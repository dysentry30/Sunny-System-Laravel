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
        Schema::create("draft_contracts", function (Blueprint $table) {
            $table->id("id_draft");
            $table->longText("id_document");
            $table->mediumText("draft_name");
            $table->mediumInteger("id_contract");
            $table->longText("draft_note");
            $table->boolean("tender_menang");
            $table->timestamp("created_at")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("draft_contracts");
    }
};
