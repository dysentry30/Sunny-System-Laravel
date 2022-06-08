<?php

namespace Database\Seeders;

use App\Models\Pasals;
use App\Models\Proyek;
use App\Models\Company;
use App\Models\Customer;
use App\Models\UnitKerja;
use App\Models\DraftContracts;
use Illuminate\Database\Seeder;
use App\Models\ContractManagements;
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
        // Customer::factory(6)->create();
        Proyek::factory(8)->create();
        // DraftContracts::factory(5)->create();


        // begin :: Unit Kerja.
            UnitKerja::create([
                'nomor_unit' => 1,
                'unit_kerja' => "Divisi Bangun Gedung",
                'divcode' => "F",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 2,
                'unit_kerja' => "Divisi Industri Plant",
                'divcode' => "U",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 3,
                'unit_kerja' => "Industri Infrastruktur 1",
                'divcode' => "G",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 4,
                'unit_kerja' => "Industri Infrastruktur 2",
                'divcode' => "H",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 5,
                'unit_kerja' => "Divisi Luar Negeri",
                'divcode' => "L",
            ]);
            
            UnitKerja::create([
                'nomor_unit' => 6,
                'unit_kerja' => "Industri Power Energi",
                'divcode' => "O",
            ]);
        // end :: Unit Kerja.
        
        // begin :: Company
            Company::create([
                'nama_company' => "ISystem Asia",
            ]);
            Company::create([
                'nama_company' => "PT Pertamina",
            ]);
        // end :: Company
    }
}
