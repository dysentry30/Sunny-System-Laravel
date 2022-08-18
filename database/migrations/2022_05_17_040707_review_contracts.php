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
            $table->id('id_review');
            $table->text("id_contract");
            $table->text("id_draft_contract");
            $table->longText("ketentuan");
            $table->tinyInteger("stage");
            // $table->longText("uraian");
            // $table->text("pic_cross");
            // $table->longText("catatan");
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
