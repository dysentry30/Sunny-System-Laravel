<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractManagements;
use App\Models\DraftContracts;
use App\Models\Pasals;

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
        ContractManagements::factory(5)->create();
        Pasals::factory(5)->create();
        // DraftContracts::factory(5)->create();
    }
}
