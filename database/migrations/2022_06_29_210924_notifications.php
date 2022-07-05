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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid("id_notification")->primary();
            $table->mediumInteger("from_id_user");
            $table->longText("message");
            $table->json("to_user");
            $table->longText("token_reset_password")->nullable();
            $table->longText("next_user")->nullable();
            $table->boolean("is_approved")->nullable();
            $table->boolean("is_rejected")->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
