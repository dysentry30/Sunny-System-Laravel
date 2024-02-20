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
        if (!Schema::hasColumn('matriks_approval_nota_rekomendasi_2', 'is_ktt')) {
            Schema::table('matriks_approval_nota_rekomendasi_2', function (Blueprint $table) {
                $table->boolean('is_ktt')->default(false);
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
        if (Schema::hasColumn('matriks_approval_nota_rekomendasi_2', 'is_ktt')) {
            Schema::table('matriks_approval_nota_rekomendasi_2', function (Blueprint $table) {
                $table->dropColumn('is_ktt');
            });
        }
    }
};
