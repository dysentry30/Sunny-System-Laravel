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
        Schema::create('claim_managements', function (Blueprint $table) {
            $table->string('id_claim', 15)->primary();
            $table->mediumText('kode_proyek');
            $table->integer('id_contract');
            $table->mediumText('pic');
            $table->longText('approval_claim')->nullable();
            $table->tinyInteger('stages');
            $table->bigInteger('nilai_claim')->nullable();
            $table->dateTime('tanggal_claim');
            $table->string('jenis_claim');
            // $table->mediumText('approval_by')->nullable();
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
        Schema::dropIfExists('claim_managements');
    }
};
