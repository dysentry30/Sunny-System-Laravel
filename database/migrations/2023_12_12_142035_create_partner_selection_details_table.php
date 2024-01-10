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
        Schema::create('partner_selection_details', function (Blueprint $table) {
            $table->id();
            $table->string('partner_id');
            $table->string('kode_proyek');
            $table->float('nilai')->nullable();
            $table->string('item');
            $table->integer('kriteria');
            $table->smallInteger('urutan');
            $table->smallInteger('index');
            $table->text('keterangan')->nullable();
            $table->text('id_document')->nullable();
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
        Schema::dropIfExists('partner_selection_details');
    }
};
