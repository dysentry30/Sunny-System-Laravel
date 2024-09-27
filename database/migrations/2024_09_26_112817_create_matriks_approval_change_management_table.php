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
        if (!Schema::hasTable('matriks_approval_change_management')) {
            Schema::create('matriks_approval_change_management', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("profit_center", 50);
                $table->foreign("profit_center")->references('profit_center')->on("proyek_pis_new")->onDelete("cascade");
                $table->string("nip", 50);
                $table->foreign("nip")->references('nip')->on("pegawai")->onDelete("cascade");
                $table->boolean("is_active")->default(true);
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
        Schema::dropIfExists('matriks_approval_change_management');
    }
};
