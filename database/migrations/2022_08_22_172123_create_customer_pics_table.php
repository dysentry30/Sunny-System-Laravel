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
        Schema::create('customer_pics', function (Blueprint $table) {
            $table->id();
            $table->integer("id_customer");
            $table->mediumText("nama_pic");
            $table->string("email_pic")->nullable();
            $table->string("jabatan_pic")->nullable();
            $table->string("phone_pic")->nullable();
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
        Schema::dropIfExists('customer_pics');
    }
};
