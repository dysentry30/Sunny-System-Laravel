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
        if (!Schema::hasTable('dokumen_aanwitjzing_contracts')) {
            Schema::create('dokumen_aanwitjzing_contracts', function (Blueprint $table) {
                $table->uuid('id');
                $table->bigInteger('index')->autoIncrement();
                $table->string('spk_intern_no')->nullable();
                $table->string('profit_center')->nullable();
                $table->string('id_document');
                $table->string('nama_document');
                $table->enum('status', ['item', 'final']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_aanwitjzing_contracts');
    }
};
