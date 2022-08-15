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
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            //#table PASAR DINI
            $table->string("nama_proyek");
            $table->string("kode_proyek")->unique();
            $table->string("unit_kerja");
            $table->integer("tahun_perolehan");
            $table->string('jenis_proyek');
            $table->string('tipe_proyek');
            $table->integer('stage');
            // $table->string('customer')->nullable();
            $table->string('pic')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->integer('bulan_pelaksanaan')->nullable();
            // $table->integer('tahun_pelaksanaan')->nullable();
            $table->string("nilai_rkap")->nullable();
            $table->string("nilai_valas_review")->nullable();
            $table->string("mata_uang_review")->nullable();
            $table->string("kurs_review")->nullable();
            $table->integer("bulan_review")->nullable();
            $table->string("nilaiok_review")->nullable();
            // $table->string("nilai_valas_awal")->nullable();
            $table->string("mata_uang_awal")->nullable();
            $table->string("kurs_awal")->nullable();
            $table->integer("bulan_awal")->nullable();
            $table->string("nilaiok_awal")->nullable();
            $table->string("laporan_kualitatif_pasdin")->nullable();
            
            //#table PASAR POTENSIAL
            $table->string("negara")->nullable();
            $table->string("sbu")->nullable();
            $table->string("provinsi")->nullable();
            $table->string("klasifikasi")->nullable();
            $table->string("sub_klasifikasi")->nullable();
            $table->string("status_pasar")->nullable();
            $table->string("dop")->nullable();
            $table->string("company")->nullable();
            $table->string("laporan_kualitatif_paspot")->nullable();
            
            //#table PRA-KUALIFIKASI
            $table->date("jadwal_pq")->nullable();
            $table->date("jadwal_proyek")->nullable();
            $table->string("hps_pagu")->nullable();
            $table->string("porsi_jo")->nullable(); 
            $table->string("ketua_tender")->nullable();
            $table->string("laporan_prakualifikasi")->nullable();
            
            //#table TENDER DIIKUTI
            $table->date("jadwal_tender")->nullable();
            $table->string("lokasi_tender")->nullable();
            $table->string("penawaran_tender")->nullable();
            // $table->string("hps_tender")->nullable();
            $table->string("laporan_tender")->nullable();
            
            //#table PEROLEHAN
            $table->string("biaya_praproyek")->nullable();
            // $table->string("penawaran_perolehan")->nullable();
            $table->string("nilai_perolehan")->nullable();
            $table->string("oe_wika")->nullable();
            $table->string("peringkat_wika")->nullable();
            $table->string("laporan_perolehan")->nullable();
            
            //#table MENANG
            $table->string("aspek_pesaing")->nullable();
            $table->string("aspek_non_pesaing")->nullable();
            $table->string("saran_perbaikan")->nullable();
            
            //#table TERKONTRAK
            $table->string("nospk_external")->nullable();
            $table->date("tglspk_internal")->nullable();
            // $table->string("jenis_proyek_terkontrak")->nullable();
            // $table->string("porsijo_terkontrak")->nullable();
            $table->integer("tahun_ri_perolehan")->nullable();
            $table->integer("bulan_ri_perolehan")->nullable();
            // $table->string("nilaiok_terkontrak")->nullable();
            // $table->string("matauang_terkontrak")->nullable();
            $table->string("nomor_terkontrak")->nullable();
            // $table->string("kursreview_terkontrak")->nullable();
            $table->date("tanggal_terkontrak")->nullable();
            $table->string("nilai_kontrak_keseluruhan")->nullable();
            $table->date("tanggal_mulai_terkontrak")->nullable();
            // $table->string("nilai_wika_terkontrak")->nullable();
            $table->date("tanggal_akhir_terkontrak")->nullable();
            $table->string("klasifikasi_terkontrak")->nullable();
            $table->date("tanggal_selesai_terkontrak")->nullable();
            $table->string("jenis_terkontrak")->nullable();
            
            //# Approval Table
            
            // Table untuk Halaman Forecast
            $table->bigInteger("forecast")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyeks');
    }
};
