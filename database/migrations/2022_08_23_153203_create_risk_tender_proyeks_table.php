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
        Schema::create('risk_tender_proyeks', function (Blueprint $table) {
            $table->id();
            $table->string("kode_proyek");
            $table->string("nama_risk_tender");
            $table->string("id_document");
            $table->string("created_by");
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
        Schema::dropIfExists('risk_tender_proyeks');
    }
};
