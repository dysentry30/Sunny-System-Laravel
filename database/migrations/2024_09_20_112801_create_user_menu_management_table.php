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
        if (!Schema::hasTable('user_menu_management')) {
            Schema::create('user_menu_management', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("nip", 30);
                $table->foreign("nip");
                $table->text("aplikasi");
                $table->text("menu");
                $table->boolean("create")->default(false);
                $table->boolean("read")->default(false);
                $table->boolean("update")->default(false);
                $table->boolean("delete")->default(false);
                $table->boolean("lock")->default(false);
                $table->boolean("approve")->default(false);
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
        Schema::dropIfExists('user_menu_management');
    }
};
