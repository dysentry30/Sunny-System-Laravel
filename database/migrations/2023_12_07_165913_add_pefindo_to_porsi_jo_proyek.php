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
        Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
            $table->integer('id_company_jo')->nullable();
            $table->integer('score_pefindo_jo')->nullable();
            $table->string('file_pefindo_jo')->nullable();
            $table->string('file_consent_npwp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('porsi_jo_proyeks', function (Blueprint $table) {
            $table->integer('id_company_jo')->nullable();
            $table->integer('score_pefindo_jo')->nullable();
            $table->string('file_pefindo_jo')->nullable();
            $table->string('file_consent_npwp')->nullable();
        });
    }
};
