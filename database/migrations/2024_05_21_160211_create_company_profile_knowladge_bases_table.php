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
        if (!Schema::hasTable('company_profile_knowladge_bases')) {
            Schema::create('company_profile_knowladge_bases', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid');
                $table->string('title');
                $table->text('documents')->nullable();
                $table->string('url')->nullable();
                $table->string('created_by');
                $table->string('updated_by');
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
        Schema::dropIfExists('company_profile_knowladge_bases');
    }
};
