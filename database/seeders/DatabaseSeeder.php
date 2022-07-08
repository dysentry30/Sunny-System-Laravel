<?php

namespace Database\Seeders;

use App\Models\Dop;
use App\Models\Sbu;
use App\Models\Faqs;
use App\Models\User;
use App\Models\Pasals;
use App\Models\Proyek;
use App\Models\Company;
use App\Models\Customer;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use App\Models\DraftContracts;
use Illuminate\Database\Seeder;
use App\Models\ContractManagements;
use App\Models\Forecast;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // ContractManagements::factory(5)->create();
        Pasals::factory(5)->create();
        Customer::factory(100)->create();
        Faqs::factory(7)->create();
        ContractManagements::factory(1)->create();
        User::factory(15)->create();
        Proyek::factory(28)->create();
        // DraftContracts::factory(5)->create();

        // begin :: Proyek.
        Proyek::create([
            'nama_proyek' => "Pengadaan JPO Arkadia Tower",
            'kode_proyek' => "FIRA001",
            'unit_kerja' => "F",
            'tahun_perolehan' => 2021,
            'tipe_proyek' => "R",
            'jenis_proyek' => "I",
            'nilai_rkap' => "1,500,000,000",
            'stage' => "1",
            'sumber_dana' => "BUMN",
            'bulan_pelaksanaan' => "Mei",
            'dop' => "DOP 1",
            'company' => "Wika Gedung",

        ]);
        Proyek::create([
            'nama_proyek' => "Pembangunan Masjid Raya Ragunan",
            'kode_proyek' => "HEPO003",
            'unit_kerja' => "H",
            'tahun_perolehan' => 2022,
            'tipe_proyek' => "P",
            'jenis_proyek' => "E",
            'nilai_rkap' => "23,500,000,000",
            'stage' => "4",
            'sumber_dana' => "BUMN",
            'bulan_pelaksanaan' => "Juni",
            'dop' => "EA",
            'company' => "Wika Industry & Konstruksi",

        ]);
        // end :: Proyek.

        // begin :: User.
        User::create([
            'name' => "Inter System Asia",
            'email' => "isa@sunny.com",
            'password' => Hash::make('password'),
            "check_administrator" => 1,
        ]);
        User::create([
            'name' => "Admin Sunny",
            'email' => "admin@sunny.com",
            'password' => Hash::make('password'),
            "check_administrator" => 1,
        ]);
        User::create([
            'name' => "User Sunny",
            'email' => "user@sunny.com",
            'password' => Hash::make('password'),
            "check_team_proyek" => 1,
        ]);
        // end :: User.


        // begin :: Unit Kerja.
        UnitKerja::create([
            'nomor_unit' => 1,
            'unit_kerja' => "Divisi Bangun Gedung",
            'divcode' => "F",
            'dop' => "DOP 1",
            'company' => "Wika Gedung",
        ]);

        UnitKerja::create([
            'nomor_unit' => 2,
            'unit_kerja' => "Divisi Industri Plant",
            'divcode' => "U",
            'dop' => "DOP 1",
            'company' => "Wika Gedung",
        ]);

        UnitKerja::create([
            'nomor_unit' => 3,
            'unit_kerja' => "Industri Infrastruktur 1",
            'divcode' => "G",
            'dop' => "DOP 2",
            'company' => "PT Wijaya Karya",
        ]);

        UnitKerja::create([
            'nomor_unit' => 4,
            'unit_kerja' => "Industri Infrastruktur 2",
            'divcode' => "H",
            'dop' => "EA",
            'company' => "Wika Industri & Konstruksi",
        ]);

        UnitKerja::create([
            'nomor_unit' => 5,
            'unit_kerja' => "Divisi Luar Negeri",
            'divcode' => "L",
            'dop' => "DOP 3",
            'company' => "PT Wijaya Karya",
        ]);

        UnitKerja::create([
            'nomor_unit' => 6,
            'unit_kerja' => "Industri Power Energi",
            'divcode' => "O",
            'dop' => "DOP 2",
            'company' => "PT Wijaya Karya",
        ]);
        // end :: Unit Kerja

        // begin :: Company
        Company::create([
            'nama_company' => "PT Wijaya Karya",
        ]);
        Company::create([
            'nama_company' => "Wika Gedung",
        ]);
        Company::create([
            'nama_company' => "Wika Industri & Konstruksig",
        ]);
        // end :: Company

        // begin :: DOP
        Dop::create([
            'dop' => "DOP 1",
        ]);
        Dop::create([
            'dop' => "DOP 2",
        ]);
        Dop::create([
            'dop' => "DOP 3",
        ]);
        Dop::create([
            'dop' => "EA",
        ]);
        // end :: DOP

        // begin :: Sumber Dana.
        SumberDana::create([
            'nama_sumber' => "BUMN",
            'kategori' => "BUMN",
            'unique_code' => "NPWP",
        ],
        [
            'nama_sumber' => "SWASTA",
            'kategori' => "LOAN",
            'unique_code' => "Bussines Permite License",
        ]);
        // begin :: Sumber Dana.

        // begin :: SBU.
        Sbu::create([
            'sbu' => "SBU1",
            'kode_sbu' => "D06E",
            'klasifikasi' => "Minyak dan Gas",
            'sub_klasifikasi' => "Fasilitas Produksi Mineral & Pertambangan",
            'referensi1' => "LPJK 3/2015",
            'referensi2' => "LPJK 4/2015",
            'referensi3' => "LPJK 6/2018",
        ]);
        // begin :: SBU.

        // begin :: Forecast.
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 1000000000,
            'month_forecast' => 1,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 1200000000,
            'month_forecast' => 2,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 1550000000,
            'month_forecast' => 3,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 300000000,
            'month_forecast' => 4,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 2800000000,
            'month_forecast' => 5,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 3250000000,
            'month_forecast' => 6,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 3500000000,
            'month_forecast' => 7,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 5400000000,
            'month_forecast' => 8,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 4750000000,
            'month_forecast' => 9,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 3150000000,
            'month_forecast' => 10,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 6200000000,
            'month_forecast' => 11,
        ]);
        Forecast::create([
            'kode_proyek' => "FIRA001",
            'nilai_forecast' => 4700000000,
            'month_forecast' => 12,
        ]);
        // begin :: Forecast.
    }
}
