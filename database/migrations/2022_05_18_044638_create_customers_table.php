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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id_customer');
            $table->string('name');
            $table->boolean('check_customer')->nullable();
            $table->boolean('check_partner')->nullable();
            $table->boolean('check_competitor')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            
            // company - information
            $table->string('jenis_instansi')->nullable();
            $table->string('journey_company')->nullable();
            $table->string('segmentation_company')->nullable();
            $table->string('kode_proyek')->nullable();
            $table->string('npwp_company')->nullable();
            $table->string('kode_nasabah')->nullable();
            $table->string('name_pic')->nullable();
            $table->string('kode_pic')->nullable();
            $table->string('email_pic')->nullable();
            $table->string('phone_number_pic')->nullable();
            
            
            // customer - performances
            $table->string("nilaiok")->nullable();//karena menggunakan (,) Int dijadikan String
            $table->string("piutang")->nullable();
            $table->string("laba")->nullable();
            $table->string("rugi")->nullable();
            
            //notre
            $table->text('note_attachment')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
