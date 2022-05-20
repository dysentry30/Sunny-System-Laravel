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
        Schema::create('review_contracts', function (Blueprint $table) {
            $table->id("id");
            $table->longText('id_review')->unique();
            $table->integer("id_contract");
            $table->text("document_name_review");
            $table->longText("note_review");
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
        Schema::dropIfExists('review_contracts');
    }
};
