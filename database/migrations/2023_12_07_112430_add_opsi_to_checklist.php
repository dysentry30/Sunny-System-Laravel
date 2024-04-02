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
        if (!Schema::hasColumn('checklist_calon_mitra_kso', 'opsi')) {
            Schema::table('checklist_calon_mitra_kso', function (Blueprint $table) {
                $table->enum('opsi', ['pilihan', 'isian', 'kombinasi'])->nullable();
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
        if (Schema::hasColumn('checklist_calon_mitra_kso', 'opsi')) {
            Schema::table('checklist_calon_mitra_kso', function (Blueprint $table) {
                $table->enum('opsi', ['pilihan', 'isian', 'kombinasi']);
            });
        }
    }
};
