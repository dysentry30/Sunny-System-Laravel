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
        Schema::create('issue_projects', function (Blueprint $table) {
            $table->bigIncrements('id_issue');
            $table->integer("id_contract");
            $table->uuid("id_document");
            $table->text("document_name_issue");
            $table->longText("note_issue");
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
        Schema::dropIfExists('issue_projects');
    }
};
