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
        if (!Schema::hasTable('master_applications')) {
            Schema::create('master_applications', function (Blueprint $table) {
                $table->uuid("id")->primary();
                $table->string("kode_aplikasi", 10)->unique();
                $table->string("nama_aplikasi", 50);
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
        Schema::dropIfExists('master_applications');
    }
};
