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
            $table->integer("id_contract");
            $table->mediumText("id_document");
            $table->text("document_name_risk");
            $table->longText("note_risk");
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
        Schema::dropIfExists('input_risks');
    }
};
