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
            $table->mediumText("id_document");
            $table->mediumInteger("id_contract");
            $table->mediumText("document_name");
            $table->mediumText("created_by");
            $table->date("start_date");
            $table->longText("draft_note");
            $table->text("title_draft");
            $table->text("pasals");
            $table->mediumInteger("draft_contract_version");
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
