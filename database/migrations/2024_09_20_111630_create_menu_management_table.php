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
        if (!Schema::hasTable('menu_management')) {
            Schema::create('menu_management', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("kode_aplikasi", 10);
                $table->foreign("kode_aplikasi")->references("kode_aplikasi")->on("master_applications")->onDelete("cascade");
                $table->string("kode_menu", 30);
                $table->foreign("kode_menu")->references("kode_menu")->on("master_menu")->onDelete("cascade");
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
        Schema::dropIfExists('menu_management');
    }
};
