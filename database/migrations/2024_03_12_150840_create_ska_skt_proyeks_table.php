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
        if (!Schema::hasTable('ska_skt_proyeks')) {
            Schema::create('ska_skt_proyeks', function (Blueprint $table) {
                $table->mediumInteger('id')->generatedAs()->autoIncrement();
                $table->string('nip');
                $table->string('emp_name');
                $table->string('nm_fungsi_bidang')->nullable();
                $table->string('no_sertifikat')->nullable();
                $table->string('type_sertifikat')->nullable();
                $table->string('institusi_penertbit_sertifikat')->nullable();
                $table->string('category_sertifikat')->nullable();
                $table->date('issued_date')->nullable();
                $table->date('expired_date')->nullable();
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
        Schema::dropIfExists('ska_skt_proyeks');
    }
};
