<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractManagements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DraftContracts;
use App\Models\Pasals;
use App\Models\Proyek;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use App\Models\Company;

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
        // Customer::factory(6)->create();
        // Proyek::factory(8)->create();
        // DraftContracts::factory(5)->create();


        // // begin :: Unit Kerja.
            UnitKerja::create([
                'nomor_unit' => 1,
                'unit_kerja' => "Divisi Bangun Gedung",
                'divcode' => "F",
                'dop' => "DOP Test",
                'company' => "I.S.A",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 2,
                'unit_kerja' => "Divisi Industri Plant",
                'divcode' => "U",
                'dop' => "DOP Test",
                'company' => "I.S.A",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 3,
                'unit_kerja' => "Industri Infrastruktur 1",
                'divcode' => "G",
                'dop' => "DOP Test",
                'company' => "I.S.A",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 4,
                'unit_kerja' => "Industri Infrastruktur 2",
                'divcode' => "H",
                'dop' => "DOP Test",
                'company' => "I.S.A",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 5,
                'unit_kerja' => "Divisi Luar Negeri",
                'divcode' => "L",
                'dop' => "DOP Test",
                'company' => "I.S.A",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 6,
                'unit_kerja' => "Industri Power Energi",
                'divcode' => "O",
                'dop' => "DOP Test",
                'company' => "I.S.A",
            ]);
        // end :: Unit Kerja
        
        // begin :: Company
            Company::create([
                'nama_company' => "ISystem Asia",
            ]);
            Company::create([
                'nama_company' => "PT Pertamina",
            ]);
        // end :: Company

        // begin :: Unit Kerja.
        SumberDana::create([
            'nama_sumber' => "BUMN",
            'kategori' => "BUMN",
            'unique_code' => "NPWP",
        ]);
        SumberDana::create([
            'nama_sumber' => "SWASTA",
            'kategori' => "LOAN",
            'unique_code' => "Bussines Permite License",
        ]);
        // begin :: Unit Kerja.
    }
}
