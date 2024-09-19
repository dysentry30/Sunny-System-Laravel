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
        if (!Schema::hasColumn('contract_final_document', 'upload_by')) {
            Schema::table('contract_final_document', function (Blueprint $table) {
                $table->string("upload_by")->nullable();
                $table->foreign("upload_by")->references("nip")->on("pegawai")->onDelete("cascade");
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
        if (!Schema::hasColumn('contract_final_document', 'upload_by')) {
            Schema::table('contract_final_document', function (Blueprint $table) {
                $table->dropColumn("upload_by");
            });
        }
    }
};
