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
        Schema::create('kriteria_project_selection_detail', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('parameter');
            $table->boolean('is_true');
            $table->integer('nilai')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('id_document')->nullable();
            $table->smallInteger('urutan');
            $table->smallInteger('index');
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
        Schema::dropIfExists('kriteria_project_selection_detail');
    }
};
