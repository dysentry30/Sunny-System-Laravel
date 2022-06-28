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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean("check_administrator")->default(0);
            $table->boolean("check_admin_kontrak")->default(0);
            $table->boolean("check_user_sales")->default(0);
            $table->boolean("check_team_proyek")->default(0);
            $table->mediumText("unit_kerja")->nullable();
            $table->longText("alamat")->nullable();
            $table->mediumText("no_hp")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
