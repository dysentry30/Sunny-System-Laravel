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
        if (!Schema::hasTable('personel_tender_proyeks')) {
            Schema::create('personel_tender_proyeks', function (Blueprint $table) {
                $table->id();
                $table->string('kode_proyek');
                $table->string('nip');
                $table->string('kategori');
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
        Schema::dropIfExists('personel_tender_proyeks');
    }
};
