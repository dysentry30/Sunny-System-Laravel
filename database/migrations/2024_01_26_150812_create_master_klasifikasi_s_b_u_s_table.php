<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('master_klasifikasi_sbu')) {
            Schema::create('master_klasifikasi_sbu', function (Blueprint $table) {
                $table->id();
                $table->uuid('id_klasifikasi');
                $table->string('klasifikasi');
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
        Schema::dropIfExists('master_klasifikasi_sbu');
    }
};
