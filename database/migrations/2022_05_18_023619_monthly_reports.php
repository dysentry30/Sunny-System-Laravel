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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->bigIncrements('id_report');
            $table->text("id_contract");
            $table->mediumText("id_document");
            $table->text("document_name_report");
            $table->longText("note_report");
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
        Schema::dropIfExists('monthly_reports');
    }
};
