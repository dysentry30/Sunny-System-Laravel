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
        Schema::create('hand_overs', function (Blueprint $table) {
            $table->bigIncrements('id_handover');
            $table->integer("id_contract");
            $table->mediumText("id_document");
            $table->text("document_name_terima");
            $table->longText("note_terima");
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
        Schema::dropIfExists('hand_overs');
    }
};
