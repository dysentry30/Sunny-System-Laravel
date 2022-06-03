<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyek>
 */
class ProyekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nama_proyek" => $this->faker->company(9),
            "kode_proyek" => $this->faker->randomNumber(6), 
            "unit_kerja" => $this->faker->randomElement(["Divisi Bangun Gedung", "Divisi Industri Plant", "Industri Infrastruktur 1", "Divisi Luar Negeri", "Industri Power Energi", "Wika Beton", "Wika Bitumen", "Wika Industri & Konstruksi"]),
            "tahun_perolehan" => $this->faker->randomElement(["2020", "2021", "2022", "2023"]), 
            "sumber_dana" => $this->faker->randomElement(["Sendiri", "Pinjam", "Sharing"]),
            "jenis_proyek" => $this->faker->randomElement(["Internal", "External"]),
            "tipe_proyek" => $this->faker->randomElement(["Retail", "Non-Retail"]),
            // "tahun_pelaksanaan" => $this->faker->randomElement(["2020", "2021", "2022", "2023"]),
            "bulan_pelaksanaan" => $this->faker->randomElement(["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]),
            "nilai_rkap" => $this->faker->numerify('##,###,000,00'),
            "nilai_valas_review" => $this->faker->numerify('#,###,000,00'),
            "mata_uang_review" => $this->faker->randomElement(["IDR", "USD", "YUAN"]),
            "kurs_review" => $this->faker->text(10),
            "bulan_review" => $this->faker->randomElement(["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]),
            "nilaiok_review" => $this->faker->numerify('#,###,000,00'),
            "nilai_valas_awal" => $this->faker->numerify('###,000,00'),
            "mata_uang_awal" => $this->faker->randomElement(["IDR", "USD", "YUAN"]),
            "kurs_awal" => $this->faker->text(10),
            "bulan_awal" => $this->faker->randomElement(["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]),
            "nilaiok_awal" => $this->faker->numerify('#,###,000,00'),
            "laporan_kualitatif_pasdin" => $this->faker->text(100),
            
            // Pasar Potensial
            "negara" => $this->faker->country(),
            "sbu" => $this->faker->randomElement(["Ya", "Tidak"]),
            "provinsi" => $this->faker->city(),
            "klasifikasi" => $this->faker->randomElement(["Ter-Klasifikasi", "Tidak Ter-Klasifikasi"]),
            "sub_klasifikasi" => $this->faker->randomElement(["Ter-Klasifikasi", "Tidak Ter-Klasifikasi"]),
            "status_pasar" => $this->faker->randomElement(["Dikelola Negara", "Dikelola swasta"]),
            "dop" => $this->faker->randomElement(["Ya", "Tidak"]),
            "company" => $this->faker->company(),
            "laporan_kualitatif_paspot" => $this->faker->text(100),
            
            // Pra-Kualifikasi
            "jadwal_pq" => $this->faker->date(),
            "jadwal_proyek" => $this->faker->date(),
            "hps_pagu" => $this->faker->numerify('###,000,00'),
            "porsi_jo" => $this->faker->numerify('## %'),
            "ketua_tender" => $this->faker->name(),
            "laporan_prakualifikasi" => $this->faker->text(100),
            
            // Tender Diikuti   
            "jadwal_tender" => $this->faker->date(),
            "penawaran_tender" => $this->faker->numerify('#,###,000,00'),
            "lokasi_tender" => $this->faker->address(),
            "hps_tender" => $this->faker->numerify('#,###,000,00'),
            "laporan_tender" => $this->faker->text(100),
            
            // Perolehan   
            "biaya_praproyek" => $this->faker->numerify('#,###,000,00'),
            "penawaran_perolehan" => $this->faker->numerify('#,###,000,00'),
            "hps_perolehan" => $this->faker->numerify('#,###,000,00'),
            "oe_wika" => $this->faker->numerify('## %'),
            "peringkat_wika" => $this->faker->randomDigit(),
            "laporan_perolehan" => $this->faker->text(100),
            
            // Menang
            "aspek_pesaing" => $this->faker->name(),
            "aspek_non_pesaing" => $this->faker->name(),
            "saran_perbaikan" => $this->faker->text(175),
            
            // Terkontrak
            "nospk_external" => $this->faker->numerify('#/##/2022-#'),
            "tglspk_internal" => $this->faker->date(),
            "jenis_proyek_terkontrak" => $this->faker->randomElement(["Internal", "External"]),
            "porsijo_terkontrak" => $this->faker->numerify('##'),
            "tahun_ri_perolehan" => $this->faker->randomElement(["2020", "2021", "2022", "2023"]),
            "bulan_ri_perolehan" => $this->faker->month(),
            "nilaiok_terkontrak" => $this->faker->numerify('#,###,000,00'),
            "matauang_terkontrak" => $this->faker->randomElement(["IDR", "USD", "YUAN"]),
            "nomor_terkontrak" => $this->faker->numerify('#/##/2022-#'),
            "kursreview_terkontrak" => $this->faker->text(10),
            "tanggal_terkontrak" => $this->faker->date(),
            "nilai_kontrak_keseluruhan" => $this->faker->numerify('#,###,000,00'),
            "tanggal_mulai_terkontrak" => $this->faker->date(),
            "nilai_wika_terkontrak" => $this->faker->numerify('#,###,000,00'),
            "tanggal_akhir_terkontrak" => $this->faker->date(),
            "klasifikasi_terkontrak" => $this->faker->randomElement(["Ter-Klasifikasi", "Tidak Ter-Klasifikasi"]),
            "tanggal_selesai_terkontrak" => $this->faker->date(),
            "jenis_terkontrak" => $this->faker->randomElement(["Internal", "External"]),
            
        ];
    }
}
