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
        Schema::create('kontrak_bertandatangans', function (Blueprint $table) {
            $table->id('id_kontrak_bertandatangan');
            $table->integer('id_contract');
            $table->mediumText('id_document');
            $table->longText('document_name');
            $table->longText('note');
            $table->text('created_by');
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
        Schema::dropIfExists('kontrak_bertandatangans');
    }
};
