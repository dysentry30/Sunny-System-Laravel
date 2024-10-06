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
        if (!Schema::hasTable('master_menu')) {
            Schema::create('master_menu', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("kode_menu", 30)->unique();
                $table->string("nama_menu");
                $table->string("kode_parrent", 30)->nullable();
                $table->string("path")->nullable();
                $table->text("icon")->nullable();
                $table->integer("urutan");
                $table->boolean("is_active");
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
        Schema::dropIfExists('master_menu');
    }
};
