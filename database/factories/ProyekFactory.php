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
        $unit_kerja = $this->faker->randomElement(["F", "U", "G", "H", "L", "O"]);
        $jenis_proyek = $this->faker->randomElement(["I", "E"]);
        $tipe_proyek = $this->faker->randomElement(["R", "P"]);
        $tahun_perolehan = $this->faker->randomElement(["2020", "2021", "2022", "2023"]);
        $no_urut = str_pad(strval(random_int(1, 99)), 3, 0, STR_PAD_LEFT);
        $kode_tahun = $tahun_perolehan ? "A" : "O";
        $kode_proyek = $unit_kerja . $jenis_proyek . $tipe_proyek . $kode_tahun . $no_urut;

        return [
            "nama_proyek" => $this->faker->company(9),
            // "kode_proyek" => $this->faker->randomElement(["FIRA000", "FERA000", "FIPA000", "FEPA000", "LIRA000", "LERA000", "LIPA000", "LEPA000", "UIRA000", "UERA000", "UIPA000", "UEPA000", "HIRA000", "HERA000", "HIPA000", "HEPA000", "GIRA000", "GERA000", "GIPA000", "GEPA000"]), 
            "kode_proyek" => $kode_proyek,
            "unit_kerja" => $unit_kerja,
            "tahun_perolehan" => $tahun_perolehan,
            "sumber_dana" => $this->faker->randomElement(["Sendiri", "Pinjam", "Sharing"]),
            "jenis_proyek" => $jenis_proyek,
            "tipe_proyek" => $tipe_proyek,
            "stage" => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
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
            "bulan_ri_perolehan" => $this->faker->month,
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
