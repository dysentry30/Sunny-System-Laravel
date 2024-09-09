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
        if (!Schema::hasColumn('contract_site_instruction', 'perubahan_id')) {
            Schema::table('contract_site_instruction', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('contract_technical_form', 'perubahan_id')) {
            Schema::table('contract_technical_form', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('contract_technical_query', 'perubahan_id')) {
            Schema::table('contract_technical_query', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('contract_field_change', 'perubahan_id')) {
            Schema::table('contract_field_change', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('contract_change_notice', 'perubahan_id')) {
            Schema::table('contract_change_notice', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('contract_change_proposal', 'perubahan_id')) {
            Schema::table('contract_change_proposal', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('contract_change_order', 'perubahan_id')) {
            Schema::table('contract_change_order', function (Blueprint $table) {
                $table->integer('perubahan_id')->nullable();
                $table->foreign('perubahan_id')->references('id_perubahan_kontrak')->on('perubahan_kontrak')->onDelete('cascade');
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
        Schema::table('contract_site_instruction', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
        Schema::table('contract_technical_form', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
        Schema::table('contract_technical_query', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
        Schema::table('contract_field_change', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
        Schema::table('contract_change_notice', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
        Schema::table('contract_change_proposal', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
        Schema::table('contract_change_order', function (Blueprint $table) {
            $table->dropColumn("perubahan_id");
        });
    }
};
